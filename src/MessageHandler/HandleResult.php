<?php

namespace Kelemen\Ocpp\MessageHandler;

use Kelemen\Ocpp\Message\Message;

class HandleResult
{
    private $result;

    private $error;

    public function __construct(?Message $result = null, ?Message $error = null)
    {
        $this->result = $result;
        $this->error = $error;
    }

    public function getResult(): ?Message
    {
        return $this->result;
    }

    public function getError(): ?Message
    {
        return $this->error;
    }
}