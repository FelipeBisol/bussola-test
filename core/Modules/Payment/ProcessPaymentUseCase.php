<?php

namespace Core\Modules\Payment;

use Core\Modules\Payment\Gateway\PaymentProcess;
use Core\Modules\Payment\Inputs\PayerInput;
use Core\Modules\Payment\Inputs\PaymentInput;
use Core\Modules\Payment\Interfaces\OutputInterface;
use Core\Modules\Payment\Rules\ProcessPaymentRule;
use Core\Modules\Payment\Rulesets\ProcessPaymentRuleset;

class ProcessPaymentUseCase
{
    private OutputInterface $output;

    public function __construct(readonly PaymentProcess $paymentProcess)
    {
    }

    public function execute(PaymentInput $paymentInput, PayerInput $payerInput)
    {
        $this->output = (new ProcessPaymentRuleset(
            new ProcessPaymentRule($this->paymentProcess, $paymentInput, $payerInput)
        ))->apply();
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }
}
