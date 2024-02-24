<?php

namespace Core\Gateway\PaymentMethods;

use Core\Entities\Cart;
use Core\Entities\CreditCard;
use Core\Entities\Installment;
use Core\Gateway\Interfaces\PaymentMethod;

class CreditCardPayment implements PaymentMethod
{
    private Cart $cart;
    private Installment $installments;
    private CreditCard $credit_cart;

    public function __construct(Cart $cart, CreditCard $credit_card, Installment $installments)
    {
        $this->cart = $cart;
        $this->credit_cart = $credit_card;
        $this->installments = $installments;
    }

    public function processPayment(): int
    {
        return $this->getOrderValue() * ((1 + 0.01) ** $this->installments->getInstallment());
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
