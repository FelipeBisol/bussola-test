<?php

namespace Core\Modules\Payment\Gateway\Interfaces;

interface PaymentMethod
{
    public function processPayment(): int;

    public function getOrderValue(): int;
}
