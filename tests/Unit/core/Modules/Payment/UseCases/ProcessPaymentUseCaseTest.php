<?php

namespace Tests\Unit\core\Modules\Payment\UseCases;

use App\Repositories\Payment\CreditCardCashPagarMeRepository;
use App\Repositories\Payment\CreditCardPagarMeRepository;
use App\Repositories\Payment\PixPagarMeRepository;
use Core\Modules\Payment\Collections\PaymentResponseCollection;
use Core\Modules\Payment\Inputs\PayerInput;
use Core\Modules\Payment\Inputs\PaymentInput;
use Core\Modules\Payment\ProcessPaymentUseCase;
use PHPUnit\Framework\TestCase;

class ProcessPaymentUseCaseTest extends TestCase
{
    public function test_process_payment_use_case_using_pix_method(): void
    {
        //arrange
        $paymentProcessor = new PixPagarMeRepository();
        $paymentInput = $this->createMock(PaymentInput::class);
        $orderTotal = random_int(1000, 9999);
        $orderSubtotal = $orderTotal * 0.10;
        $paymentInput->method('getType')->willReturn('PIX');
        $paymentInput->method('getInstallments')->willReturn(0);
        $paymentInput->method('getTotal')->willReturn($orderTotal);
        $payerInput = $this->createMock(PayerInput::class);
        $payerInput->method('getDocument')->willReturn('99999999999');
        $useCase = new ProcessPaymentUseCase($paymentProcessor);

        //act
        $useCase->execute($paymentInput, $payerInput);
        $response = $useCase->getOutput()->getPresenter()->toArray();

        //assert
        $this->assertEquals([
            "status" => [
                "code" => 200,
                "message" => "Success",
            ],
            "data" => [
                "api_response" => [
                    "message" => "success",
                    "status" => 200,
                    "data" => [
                        "total" => $orderSubtotal
                    ]
                ]
            ]
        ], $response);
    }

    public function test_process_payment_use_case_using_credit_card_cash_method(): void
    {
        //arrange
        $paymentProcessor = new CreditCardCashPagarMeRepository();
        $paymentInput = $this->createMock(PaymentInput::class);
        $orderTotal = random_int(1000, 9999);
        $orderSubtotal = $orderTotal * 0.10;
        $paymentInput->method('getType')->willReturn('CreditCardCash');
        $paymentInput->method('getInstallments')->willReturn(0);
        $paymentInput->method('getTotal')->willReturn($orderTotal);
        $payerInput = $this->createMock(PayerInput::class);
        $payerInput->method('getDocument')->willReturn('99999999999');
        $useCase = new ProcessPaymentUseCase($paymentProcessor);

        //act
        $useCase->execute($paymentInput, $payerInput);
        $response = $useCase->getOutput()->getPresenter()->toArray();

        //assert
        $this->assertEquals([
            "status" => [
                "code" => 200,
                "message" => "Success",
            ],
            "data" => [
                "api_response" => [
                    "message" => "success",
                    "status" => 200,
                    "data" => [
                        "total" => $orderSubtotal
                    ]
                ]
            ]
        ], $response);
    }

    public function test_process_payment_use_case_using_credit_card(): void
    {
        //arrange
        $paymentProcessor = new CreditCardPagarMeRepository();
        $paymentInput = $this->createMock(PaymentInput::class);
        $orderTotal = random_int(1000, 9999);
        $installments = random_int(2, 12);
        $orderSubtotal = $orderTotal * ((1 + 0.01) ** $installments);
        $paymentInput->method('getType')->willReturn('CreditCard');
        $paymentInput->method('getInstallments')->willReturn($installments);
        $paymentInput->method('getTotal')->willReturn($orderTotal);
        $payerInput = $this->createMock(PayerInput::class);
        $payerInput->method('getDocument')->willReturn('99999999999');
        $useCase = new ProcessPaymentUseCase($paymentProcessor);

        //act
        $useCase->execute($paymentInput, $payerInput);
        $response = $useCase->getOutput()->getPresenter()->toArray();

        //assert
        $this->assertEquals([
            "status" => [
                "code" => 200,
                "message" => "Success",
            ],
            "data" => [
                "api_response" => [
                    "message" => "success",
                    "status" => 200,
                    "data" => [
                        "total" => $orderSubtotal
                    ]
                ]
            ]
        ], $response);
    }
}
