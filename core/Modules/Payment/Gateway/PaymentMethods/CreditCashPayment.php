<?php

namespace Core\Modules\Payment\Gateway\PaymentMethods;

use Core\Modules\Payment\Entities\Cart;
use Core\Modules\Payment\Entities\CreditCard;
use Core\Modules\Payment\Gateway\Interfaces\PaymentMethod;

class CreditCashPayment implements PaymentMethod
{
    private Cart $cart;
    private int $discount_value;
    private CreditCard $credit_cart;

    public function __construct(Cart $cart, CreditCard $credit_card)
    {
        $this->cart = $cart;
        $this->credit_cart = $credit_card;
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
