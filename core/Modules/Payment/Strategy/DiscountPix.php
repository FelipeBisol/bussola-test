<?php

namespace Core\Modules\Payment\Strategy;

use Core\Modules\Payment\Interfaces\CalculateTotalOrder;

class DiscountPix implements CalculateTotalOrder
{
    public function calculate(float $total): float
    {
        return $total * 0.10;
    }

    public function setInstallments(int $quantity): self
    {
        return $this;
    }
}
