<?php

namespace App\Services\Webhook\Zendesk;

use App\Services\ValueObject\IntegrationType;
use App\Services\Webhook\Core\HMacSignature;
use App\Services\Webhook\Core\WebhookProcessor;
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
            app(HMacSignature::class),
            app(WebhookProcessor::class)
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
