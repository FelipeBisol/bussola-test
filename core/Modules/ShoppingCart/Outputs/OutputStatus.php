<?php

namespace Core\Modules\ShoppingCart\Outputs;

class OutputStatus
{
    public function __construct(private int $code, private string $message)
    {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
