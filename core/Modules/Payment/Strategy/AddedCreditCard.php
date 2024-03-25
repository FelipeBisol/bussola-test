<?php

namespace Core\Modules\Payment\Strategy;

use Core\Modules\Payment\Interfaces\CalculateTotalOrder;

class AddedCreditCard implements CalculateTotalOrder
{
    private int $installments;

    public function calculate(float $total): float
    {
        return $total * ((1 + 0.01) ** $this->installments);
    }

    public function setInstallments(int $quantity): self
    {
        $this->installments = $quantity;
        return $this;
    }
}
