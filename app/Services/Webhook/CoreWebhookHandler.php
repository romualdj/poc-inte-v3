<?php

namespace App\Services\Webhook;

use App\Contracts\Webhook\WebhookProcessorInterface;
use App\Contracts\Webhook\WebhookVerifierInterface;
use App\Exceptions\WebhookProcessingException;
use App\Exceptions\WebhookVerificationException;
use App\Services\ValueObject\Payload;
use App\Services\Webhook\Zendesk\TicketHandlerVerifier;

class CoreWebhookHandler
{

    public function __construct(
        protected WebhookRemoteStore        $webhookStore,
        protected TicketHandlerVerifier     $handlerVerifier,
        protected WebhookVerifierInterface  $webhookVerifier,
        protected WebhookProcessorInterface $webhookProcessor
    )
    {
    }

    /**
     * @param Payload $payload
     * @return void
     * @throws WebhookVerificationException
     * @throws WebhookProcessingException
     */
    public function handle(Payload $payload): void
    {
        if (!$this->verifyRequest($payload)) {
            throw new WebhookVerificationException('Webhook verification failed');
        }

        if (!$this->canHandleTicket($payload)) {
            throw new WebhookVerificationException('Ticket handler verification failed');
        }

        $this->webhookStore->handle($payload->request());
        $this->webhookProcessor->process($payload->request()->all());
    }

    public function canHandleTicket(Payload $payload): bool
    {
        return $this->handlerVerifier->canHandle($payload->request());
    }

    protected function verifyRequest(Payload $payload): bool
    {
        return $this->webhookVerifier->verify($payload->request());
    }
}
