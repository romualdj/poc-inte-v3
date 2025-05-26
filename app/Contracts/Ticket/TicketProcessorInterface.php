<?php

namespace App\Contracts\Ticket;

use App\Models\Ticket;

interface TicketProcessorInterface
{
    /**
     * Process a ticket from webhook payload
     */
    public function process(array $payload): ?Ticket;
}
