<?php

namespace Core\Modules\Payment\Inputs;

class PaymentInput
{
    public function __construct(private readonly string $type, private readonly int $installments, private readonly int $total)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
