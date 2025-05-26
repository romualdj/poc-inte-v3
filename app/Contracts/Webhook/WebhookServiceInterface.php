<?php

namespace App\Contracts\Webhook;

use Illuminate\Http\Request;

interface WebhookServiceInterface
{
    /**
     * Verify the webhook signature
     */
    public function verifySignature(Request $request): bool;

    /**
     * Process the webhook payload
     */
    public function processWebhook(array $payload): void;
}
