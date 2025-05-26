<?php

namespace App\Providers;

use App\Contracts\Webhook\WebhookHandlerInterface;
use App\Services\Webhook\WebhookHandlerFactory;
use App\Services\Webhook\Zendesk\ZendeskWebhookHandler;
use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        // Register and tag webhook handlers
        $this->app->tag([
            ZendeskWebhookHandler::class,
        ], WebhookHandlerInterface::class);

        // Register factory with tagged services
        $this->app->singleton(WebhookHandlerFactory::class, function ($app) {
            return new WebhookHandlerFactory(
                $app->tagged(WebhookHandlerInterface::class)
            );
        });
    }
}
