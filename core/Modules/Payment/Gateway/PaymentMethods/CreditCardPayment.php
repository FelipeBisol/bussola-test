<?php

namespace Core\Modules\Payment\Gateway\PaymentMethods;

use Core\Modules\Payment\Entities\Cart;
use Core\Modules\Payment\Entities\CreditCard;
use Core\Modules\Payment\Entities\Installment;
use Core\Modules\Payment\Gateway\Interfaces\PaymentMethod;

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
