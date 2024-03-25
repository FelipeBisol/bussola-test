<?php

namespace Core\Modules\Payment\Interfaces;

interface CalculateTotalOrder
{
    public function calculate(float $total): float;

    public function setInstallments(int $quantity): self;
}
