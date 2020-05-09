<?php

namespace Kelemen\Ocpp;

use Kelemen\Ocpp\Endpoint\Endpoint;
use Kelemen\Ocpp\MessageHandler\HandleResult;
use Kelemen\Ocpp\MessageHandler\MessageHandler;
use Swoole\WebSocket\Frame;

class Server
{
    private $messageHandler;

    private $endpoints = [];

    public function __construct(MessageHandler $messageHandler)
    {
        $this->messageHandler = $messageHandler;
    }

    public function onMessage(Frame $frame): HandleResult
    {
        return $this->messageHandler->handle($frame->data);
    }

    public function registerEndpoint(string $type, Endpoint $endpoint)
    {
        $this->endpoints[$type] = $endpoint;
    }
}