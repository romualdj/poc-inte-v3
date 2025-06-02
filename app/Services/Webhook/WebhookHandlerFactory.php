<?php

namespace App\Services\Webhook;

use App\Contracts\Webhook\WebhookHandlerInterface;
use App\Services\ValueObject\Payload;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WebhookHandlerFactory
{
    /**
     * @var Collection<WebhookHandlerInterface>
     */
    private readonly Collection $handlers;

    /**
     * @param WebhookHandlerInterface[] $handlers
     */
    public function __construct(array $handlers)
    {
        $this->handlers = collect($handlers);
    }

    /**
     * Get the first handler that can handle the request.
     *
     * @param Request $request
     * @return WebhookHandlerInterface|null
     */
    public function getHandler(Request $request): ?WebhookHandlerInterface
    {
        return $this->handlers->first(
            fn (WebhookHandlerInterface $handler) => $handler->canHandleWebhook($request)
        );
    }
}
