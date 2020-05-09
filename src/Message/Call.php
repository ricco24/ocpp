<?php

namespace Kelemen\Ocpp\Message;

class Call implements Message
{
    private $messageTypeId = 2;

    private $messageId;

    private $action;

    private $payload;

    public function __construct(array $data)
    {
        $this->messageId = $data[1];
        $this->action = $data[2];
        $this->payload = $data[3];
    }

    public function getMessageTypeId()
    {
        return $this->messageTypeId;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}