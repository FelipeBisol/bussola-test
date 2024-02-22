<?php

namespace Core\Gateway\Interfaces;

use Core\Entities\Cart;

interface PaymentMethod
{
    public function processPayment(): int;

    public function getOrderValue(): int;
}
