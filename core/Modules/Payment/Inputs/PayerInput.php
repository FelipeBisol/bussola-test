<?php

namespace Core\Modules\Payment\Inputs;

class PayerInput
{
    public function __construct(readonly string $document)
    {
    }

    public function getDocument(): string
    {
        return $this->document;
    }
}
