<?php

namespace Tests\Unit\core\Gateway;

use Core\Collections\CartItemCollection;
use Core\Entities\Cart;
use Core\Entities\CartItem;
use Core\Entities\CreditCart;
use Core\Gateway\PaymentMethods\CreditCardPayment;
use Core\Gateway\PaymentMethods\CreditCashPayment;
use Core\Gateway\PaymentMethods\PixPayment;
use Core\Gateway\PaymentProcess;
use PHPUnit\Framework\TestCase;

class PaymentProcessTest extends TestCase
{
    public function test_pix()
    {
        //arrange
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('15000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        $paymentMethod = new PixPayment($cart);

        //act
        $paymentProcess = new PaymentProcess($paymentMethod);


        //assert
        $this->assertEquals(31500, $paymentProcess->process());
        $this->assertEquals(35000, $paymentMethod->getOrderValue());
    }

    public function test_credit_cash()
    {
        //arrange
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('30000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');
        $card = $this->createMock(CreditCart::class);

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        $paymentMethod = new CreditCashPayment($cart, $card);

        //act
        $paymentProcess = new PaymentProcess($paymentMethod);


        //assert
        $this->assertEquals(45000, $paymentProcess->process());
        $this->assertEquals(50000, $paymentMethod->getOrderValue());
    }

    public function test_credit_card()
    {
        //arrange
        $installments = 10;
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('30000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');
        $card = $this->createMock(CreditCart::class);

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        $paymentMethod = new CreditCardPayment($cart, $card, $installments);

        //act
        $paymentProcess = new PaymentProcess($paymentMethod);

        //assert
        $this->assertEquals(5523110, $paymentProcess->process());
        $this->assertEquals(50000, $paymentMethod->getOrderValue());
    }
}
