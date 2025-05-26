<?php

namespace App\Services\Webhook;

use App\Contracts\Webhook\WebhookHandlerInterface;
use App\Contracts\Webhook\WebhookProcessorInterface;
use App\Contracts\Webhook\WebhookServiceInterface;
use App\Contracts\Webhook\WebhookVerifierInterface;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;

class WebhookRemoteStore
{

    public function __construct(
        protected Dispatcher $dispatcher,
    )
    {
    }

    public function handle(Request $request): void
    {
        $this->dispatcher->dispatch(new Job($request));
    }
}
