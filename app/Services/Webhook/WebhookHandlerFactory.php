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
    private Collection $handlers;

    /**
     * @param WebhookHandlerInterface[] $handlers
     */
    public function __construct(array $handlers)
    {
        $this->handlers = collect($handlers);
    }

    public function getHandler(Request $request): ?WebhookHandlerInterface
    {
        return $this->handlers->first(
            fn (WebhookHandlerInterface $handler) => $handler->canHandleTicketingTool($request)
        );
    }
}
