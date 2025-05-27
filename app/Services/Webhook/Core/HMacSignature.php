<?php

namespace App\Services\Webhook\Core;

use App\Contracts\Webhook\WebhookVerifierInterface;
use Illuminate\Http\Request;

class HMacSignature implements WebhookVerifierInterface
{

    public function verify(Request $request): bool
    {
        return true;
    }
}
