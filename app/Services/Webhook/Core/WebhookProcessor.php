<?php

namespace App\Services\Webhook\Core;

use App\Contracts\Webhook\WebhookProcessorInterface;

class WebhookProcessor implements WebhookProcessorInterface
{

    public function process(array $payload): void
    {
        //send to TC
    }
}
