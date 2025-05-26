<?php

namespace App\Contracts\Webhook;

use Illuminate\Http\Request;

interface WebhookVerifierInterface
{
    /**
     * Handle the webhook request
     */
    public function verify(Request $request): bool;

}
