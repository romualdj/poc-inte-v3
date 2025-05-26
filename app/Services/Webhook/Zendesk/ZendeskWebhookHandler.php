<?php

namespace App\Services\Webhook\Zendesk;

use App\Contracts\Webhook\WebhookProcessorInterface;
use App\Contracts\Webhook\WebhookVerifierInterface;
use App\Services\ValueObject\IntegrationType;
use App\Services\Webhook\CoreWebhookHandler;
use App\Services\Webhook\WebhookRemoteStore;
use Illuminate\Http\Request;

class ZendeskWebhookHandler
{
    public function handler(): CoreWebhookHandler
    {
        return new CoreWebhookHandler(
            app(WebhookRemoteStore::class),
            app(TicketHandlerVerifier::class),
            app(WebhookVerifierInterface::class),
            app(WebhookProcessorInterface::class)
        );
    }

    public function canHandleTicketingTool(Request $request): bool
    {
        // Determine if this is a Zendesk webhook based on headers or payload
        return $request->header('X-Zendesk-Webhook') !== null;
    }
    public function integrationType(): IntegrationType
    {
        return IntegrationType::ZENDESK;
    }
}
