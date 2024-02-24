<?php

namespace Core\Modules\Payment\Gateway\PaymentMethods;

use Core\Modules\Payment\Entities\Cart;
use Core\Modules\Payment\Gateway\Interfaces\PaymentMethod;

class PixPayment implements PaymentMethod
{
    private Cart $cart;
    protected int $discount_value;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->discount_value = $this->getOrderValue() * 0.10;
    }

    public function processPayment(): int
    {
        return $this->getOrderValue() - $this->discount_value;
    }

    public function getOrderValue(): int
    {
        $value = 0;

        foreach ($this->cart->items->getIterator() as $item) {
            $value += $item->getPrice();
        }

        return $value;
    }
}
