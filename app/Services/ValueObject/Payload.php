<?php

namespace App\Services\ValueObject;

use Illuminate\Http\Request;

class Payload
{
    public function __construct(
        protected readonly IntegrationType $integrationType,
        protected readonly Request $request
    ) {
    }

    public function integrationType(): IntegrationType
    {
        return $this->integrationType;
    }

    public function request(): Request
    {
        return $this->request;
    }
}
