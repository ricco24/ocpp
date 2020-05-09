<?php

namespace Kelemen\Ocpp\MessageHandler;

use Kelemen\Ocpp\Endpoint\Endpoint;
use Kelemen\Ocpp\Message\CallError;
use Kelemen\Ocpp\Message\CallResult;

class MessageHandler
{
    private $endpoints = [];

    public function addEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[$endpoint->getName()] = $endpoint;
    }

    public function handle(string $string): ?HandleResult
    {
        $data = json_decode($string, true);
        if ($data === null) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'Message is not valid JSON'));
        }

        if (!isset($data[0])) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'MessageTypeId is not set'));
        }

        if (!isset($data[1])) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'MessageId is not set'));
        }

        $messageTypeId = $data[0];
        if (!is_int($messageTypeId)) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'MessageTypeId is not integer'));
        }

        $messageId = $data[1];
        if (!is_string($messageId)) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'MessageId is not string'));
        }

        if (strlen($messageId) !== 36) {
            return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, 'Invalid MessageId length (' . strlen($messageId) . '), 36 expected'));
        }

        switch ($data[0]) {
            case 2:
                return $this->createCall($messageId, $data);
                break;
            case 3:
                break;
            case 4:
                break;
            default:
                return new HandleResult(null, new CallError(-1, CallError::ERROR_GENERIC_ERROR, sprintf('MessageTypeId %d not supported', $messageTypeId)));
        }
    }

    private function createCall(string $messageId, array $data): HandleResult
    {
        if (!isset($data[2])) {
            return new HandleResult(null, new CallError($messageId, CallError::ERROR_GENERIC_ERROR, 'Action is not set'));
        }

        if (!isset($data[3])) {
            return new HandleResult(null, new CallError($messageId, CallError::ERROR_GENERIC_ERROR, 'Payload is not set'));
        }

        $action = $data[2];
        $payload = $data[3];

        if (!isset($this->endpoints[$action])) {
            return new HandleResult(null, new CallError($messageId, CallError::ERROR_NOT_IMPLEMENTED, 'Action not implemented'));
        }

        /** @var Endpoint $endpoint */
        $endpoint = $this->endpoints[$action];
        $validateError = $endpoint->validate($payload);
        if ($validateError) {
            return new HandleResult(null, $validateError);
        };
        $resultPayload = $endpoint->handle($payload);
        return new HandleResult(new CallResult($data[1], $resultPayload));
    }
}