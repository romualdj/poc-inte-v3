<?php

namespace App\Contracts\Webhook;

use App\Services\ValueObject\IntegrationType;
use App\Services\Webhook\CoreWebhookHandler;
use Illuminate\Http\Request;

interface WebhookHandlerInterface
{
    public function handler(): CoreWebhookHandler;

    public function canHandleTicketingTool(Request $request): bool;

    public function integrationType(): IntegrationType;
}
