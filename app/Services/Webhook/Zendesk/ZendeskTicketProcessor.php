<?php

namespace App\Services\Webhook\Zendesk;

use App\Contracts\Ticket\TicketProcessorInterface;
use App\Models\Ticket;

class ZendeskTicketProcessor implements TicketProcessorInterface
{
    public function process(array $payload): ?Ticket
    {
        return new Ticket();
    }

    private function mapStatus(string $zendeskStatus): string
    {
        return match ($zendeskStatus) {
            'new' => 'open',
            'open' => 'in_progress',
            'pending' => 'waiting',
            'hold' => 'on_hold',
            'solved' => 'resolved',
            'closed' => 'closed',
            default => 'open',
        };
    }

    private function mapPriority(string $zendeskPriority): string
    {
        return match ($zendeskPriority) {
            'urgent' => 'critical',
            'high' => 'high',
            'normal' => 'medium',
            'low' => 'low',
            default => 'medium',
        };
    }
}
