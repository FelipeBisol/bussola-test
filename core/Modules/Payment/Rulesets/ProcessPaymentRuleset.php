<?php

namespace Core\Modules\Payment\Rulesets;

use Core\Modules\Payment\Outputs\OutputStatus;
use Core\Modules\Payment\Outputs\ProcessPaymentOutput;
use Core\Modules\Payment\Rules\ProcessPaymentRule;

class ProcessPaymentRuleset
{
    public function __construct(private readonly ProcessPaymentRule $processPaymentRule)
    {
    }

    public function apply(): ProcessPaymentOutput
    {
        return new ProcessPaymentOutput(
            new OutputStatus(200, 'Success'),
            $this->processPaymentRule->apply()
        );
    }
}
