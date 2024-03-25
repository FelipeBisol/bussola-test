<?php

namespace Core\Modules\Payment\Rules;

use Core\Modules\Payment\Collections\PaymentResponseCollection;
use Core\Modules\Payment\Enums\PaymentEnum;
use Core\Modules\Payment\Gateway\PaymentProcess;
use Core\Modules\Payment\Inputs\PayerInput;
use Core\Modules\Payment\Inputs\PaymentInput;
use Core\Modules\Payment\Resolvers\CalculateTotalResolver;
use Core\Modules\Payment\Resolvers\PaymentTypeResolver;

class ProcessPaymentRule
{
    public function __construct(readonly PaymentProcess $paymentProcess, readonly PaymentInput $paymentInput, readonly PayerInput $payerInput)
    {
    }

    public function apply(): PaymentResponseCollection
    {
        $paymentType = PaymentEnum::from($this->paymentInput->getType());
        $resolver = CalculateTotalResolver::resolve($paymentType, $this->paymentInput->getInstallments());
        $totalAmount = $resolver->calculate($this->paymentInput->getTotal());
        $paymentTypeResolver = PaymentTypeResolver::resolve($paymentType, $this->payerInput);

        $this->paymentProcess->process($paymentTypeResolver, $totalAmount);

        return $this->paymentProcess->getResponse();
    }
}
