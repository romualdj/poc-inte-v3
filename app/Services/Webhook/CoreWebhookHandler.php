<?php

namespace App\Services\Webhook;

use App\Contracts\Webhook\WebhookProcessorInterface;
use App\Contracts\Webhook\WebhookVerifierInterface;
use App\Exceptions\WebhookProcessingException;
use App\Exceptions\WebhookVerificationException;
use App\Services\ValueObject\Payload;
use App\Contracts\Webhook\WebhookContentVerifierInterface;

class CoreWebhookHandler
{
    public function __construct(
        protected readonly WebhookRemoteStore $webhookStore,
        protected readonly WebhookContentVerifierInterface $contentVerifier,
        protected readonly WebhookVerifierInterface $webhookVerifier,
        protected readonly WebhookProcessorInterface $webhookProcessor
    ) {
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

        if (!$this->canHandleContent($payload)) {
            throw new WebhookVerificationException('Content verification failed');
        }

        $this->webhookStore->handle($payload->request());
        $this->webhookProcessor->process($payload->request()->all());
    }

    public function canHandleContent(Payload $payload): bool
    {
        return $this->contentVerifier->canHandle($payload->request());
    }

    protected function verifyRequest(Payload $payload): bool
    {
        return $this->webhookVerifier->verify($payload->request());
    }
}
