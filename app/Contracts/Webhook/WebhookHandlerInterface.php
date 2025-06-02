<?php

namespace App\Contracts\Webhook;

use App\Services\ValueObject\IntegrationType;
use App\Services\Webhook\CoreWebhookHandler;
use Illuminate\Http\Request;

interface WebhookHandlerInterface
{
    /**
     * Get the webhook handler.
     *
     * @return CoreWebhookHandler
     */
    public function handler(): CoreWebhookHandler;

    /**
     * Determine if this handler can handle the webhook request.
     *
     * @param Request $request
     * @return bool
     */
    public function canHandleWebhook(Request $request): bool;

    /**
     * Get the integration type.
     *
     * @return IntegrationType
     */
    public function integrationType(): IntegrationType;
}
