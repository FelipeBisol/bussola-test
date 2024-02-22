<?php

namespace Core\Gateway\PaymentMethods;

use Core\Entities\Cart;
use Core\Gateway\Interfaces\PaymentMethod;

class PixPayment implements PaymentMethod
{
    private Cart $cart;
    private int $discount_value;

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
