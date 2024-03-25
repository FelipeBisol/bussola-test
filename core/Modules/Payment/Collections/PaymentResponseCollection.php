<?php

namespace Core\Modules\Payment\Collections;

class PaymentResponseCollection
{
    public function __construct(readonly int $status, readonly string $message, readonly array $data)
    {

    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
