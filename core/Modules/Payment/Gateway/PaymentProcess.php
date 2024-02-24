<?php

namespace Core\Modules\Payment\Gateway;

use Core\Modules\Payment\Gateway\Interfaces\PaymentMethod;

abstract class PaymentProcess
{
    protected PaymentMethod $paymentMethod;
    protected int $paymentProcessed;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function process(): int
    {
        $this->paymentProcessed = $this->paymentMethod->processPayment();

        return $this->paymentProcessed;
    }

    public function getResponse(): string
    {
        return 'O valor total da compra é: R$ ' . number_format($this->paymentProcessed / 100, 2, ',', '.');
    }
}
