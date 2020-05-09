<?php

namespace Kelemen\Ocpp\Message;

class CallResult implements Message
{
    private $messageTypeId = 3;

    private $messageId;

    private $payload;

    public function __construct(
        string $messageId,
        array $payload
    ) {
        $this->messageId = $messageId;
        $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}