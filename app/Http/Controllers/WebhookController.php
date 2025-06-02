<?php

namespace App\Http\Controllers;

use App\Exceptions\WebhookProcessingException;
use App\Exceptions\WebhookVerificationException;
use App\Http\Controllers\Controller;
use App\Services\ValueObject\Payload;
use App\Services\Webhook\WebhookHandlerFactory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class WebhookController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly WebhookHandlerFactory $factory
    ) {
    }

    public function handle(Request $request): Response
    {
        $handler = $this->factory->getHandler($request);

        if (!$handler) {
            Log::error('Handler not found for webhook', [
                'request' => $request->all(),
            ]);
            return $this->responseFactory->noContent();
        }

        try {
            $handler->handler()->handle(new Payload(
                $handler->integrationType(),
                $request
            ));

            Log::info('Webhook handled successfully', [
                'integration' => $handler->integrationType()->name,
            ]);

            return $this->responseFactory->noContent();
        } catch (WebhookVerificationException $e) {
            Log::warning('Webhook not handled', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return $this->responseFactory->noContent();
        } catch (WebhookProcessingException $e) {
            Log::error('Webhook processing failed', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return $this->responseFactory->noContent();
        } catch (Throwable $e) {
            Log::critical('Unexpected error in webhook handler', [
                'integration' => $handler->integrationType()->name,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            // Consider returning a different status code for unexpected errors
            return $this->responseFactory->noContent();
        }
    }
}
