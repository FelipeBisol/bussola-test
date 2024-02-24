<?php

namespace Core\Gateway\PaymentMethods;

use Core\Entities\Cart;
use Core\Entities\CreditCard;
use Core\Gateway\Interfaces\PaymentMethod;

class CreditCardPayment implements PaymentMethod
{
    private Cart $cart;
    private int $installments;
    private CreditCard $credit_cart;

    public function __construct(Cart $cart, CreditCard $credit_card, int $installments)
    {
        $this->cart = $cart;
        $this->credit_cart = $credit_card;
        $this->installments = $installments;
    }

    public function processPayment(): int
    {
        return $this->getOrderValue() * ((1 + 0.01) ** $this->installments);
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
