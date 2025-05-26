<?php

namespace App\Contracts\Webhook;

interface WebhookProcessorInterface
{
    public function process(array $payload): void;
}
