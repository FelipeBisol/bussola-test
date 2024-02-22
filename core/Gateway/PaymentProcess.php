<?php

namespace Core\Gateway;

use Core\Gateway\Interfaces\PaymentMethod;

class PaymentProcess
{
    private PaymentMethod $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function process(): int
    {
        return $this->paymentMethod->processPayment();
    }
}
