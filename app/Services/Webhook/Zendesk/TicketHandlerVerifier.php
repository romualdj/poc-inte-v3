<?php

namespace App\Services\Webhook\Zendesk;

use App\Contracts\Webhook\WebhookContentVerifierInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TicketHandlerVerifier implements WebhookContentVerifierInterface
{
    /**
     * Verify if the webhook content can be handled
     *
     * @param Request $request
     * @return bool
     */
    public function canHandle(Request $request): bool
    {
        $tags = Arr::get($request->all(), 'tags', []);

        return in_array('onepilot', $tags);
    }
}
