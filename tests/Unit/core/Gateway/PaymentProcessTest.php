<?php

namespace Tests\Unit\core\Gateway;

use Core\Modules\Payment\Collections\CartItemCollection;
use Core\Modules\Payment\Entities\Cart;
use Core\Modules\Payment\Entities\CartItem;
use Core\Modules\Payment\Entities\CreditCard;
use Core\Modules\Payment\Entities\Installment;
use Core\Modules\Payment\Exceptions\InstallmentException;
use Core\Modules\Payment\Gateway\PaymentMethods\CreditCardPayment;
use Core\Modules\Payment\Gateway\PaymentMethods\CreditCashPayment;
use Core\Modules\Payment\Gateway\PaymentMethods\PixPayment;
use Core\Modules\Payment\Gateway\PaymentProcess;
use Core\Modules\Payment\UseCases\ProcessCreditCardPayment;
use Core\Modules\Payment\UseCases\ProcessCreditCashPayment;
use Core\Modules\Payment\UseCases\ProcessPixPayment;
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
        $paymentProcess = new ProcessPixPayment($paymentMethod);

        //assert
        $this->assertEquals(31500, $paymentProcess->process());
        $this->assertEquals(35000, $paymentMethod->getOrderValue());
        $this->assertEquals('A sua compra recebeu um desconto de: R$ 35,00. Ficando no valor total de: R$ 315,00', $paymentProcess->getResponse());
    }

    public function test_credit_cash()
    {
        //arrange
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('30000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');
        $card = $this->createMock(CreditCard::class);

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        $paymentMethod = new CreditCashPayment($cart, $card);

        //act
        $paymentProcess = new ProcessCreditCashPayment($paymentMethod);


        //assert
        $this->assertEquals(45000, $paymentProcess->process());
        $this->assertEquals(50000, $paymentMethod->getOrderValue());
        $this->assertEquals('A sua compra recebeu um desconto de: R$ 50,00. Ficando no valor total de: R$ 450,00', $paymentProcess->getResponse());
    }

    public function test_credit_card()
    {
        //arrange
        $installments = $this->createMock(Installment::class);
        $installments->method('getInstallment')->willReturn(10);
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('30000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');
        $card = $this->createMock(CreditCard::class);

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        $paymentMethod = new CreditCardPayment($cart, $card, $installments);

        //act
        $paymentProcess = new ProcessCreditCardPayment($paymentMethod);

        //assert
        $this->assertEquals(55231, $paymentProcess->process());
        $this->assertEquals(50000, $paymentMethod->getOrderValue());
    }

    public function test_credit_card_failed_because_installments_is_invalid()
    {
        //arrange
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getPrice')->willReturn('30000');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getPrice')->willReturn('20000');
        $card = $this->createMock(CreditCard::class);

        $collection = new CartItemCollection();
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        //assert
        $this->expectException(InstallmentException::class);

        $installments = new Installment(14);
        $paymentMethod = new CreditCardPayment($cart, $card, $installments);
    }
}
