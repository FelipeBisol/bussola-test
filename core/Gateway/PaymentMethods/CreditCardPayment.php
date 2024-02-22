<?php

namespace Core\Gateway\PaymentMethods;

use Core\Entities\Cart;
use Core\Entities\CreditCart;
use Core\Gateway\Interfaces\PaymentMethod;

class CreditCardPayment implements PaymentMethod
{
    private Cart $cart;
    private int $installments;
    private CreditCart $credit_cart;

    public function __construct(Cart $cart, CreditCart $credit_card, int $installments)
    {
        $this->cart = $cart;
        $this->credit_cart = $credit_card;
        $this->installments = $installments;
    }

    public function processPayment(): int
    {
        return ($this->getOrderValue() * pow((1 + 0.01), $this->installments)) * 100;
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
