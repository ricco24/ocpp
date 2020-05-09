<?php

namespace Kelemen\Ocpp\Endpoint;

interface Endpoint
{
    public function getName(): string;

    public function validate($payload);

    public function handle($payload): array;
}
