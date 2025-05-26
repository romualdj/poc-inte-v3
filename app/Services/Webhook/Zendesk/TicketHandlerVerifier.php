<?php

namespace App\Services\Webhook\Zendesk;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TicketHandlerVerifier
{

    public function __construct(
    )
    {
    }

    public function canHandle(Request $request): bool
    {
        $tags = Arr::get($request->all(), 'tags', []);
        //$assignee = Arr::get($request->all(), 'assignee', []);

        return in_array('onepilot', $tags);
    }
}
