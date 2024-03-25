<?php

namespace Core\Modules\ShoppingCart\Rulesets;

use Core\Modules\ShoppingCart\Inputs\ItemCartIdInput;
use Core\Modules\ShoppingCart\Outputs\CalculateCartOutput;
use Core\Modules\ShoppingCart\Outputs\OutputStatus;
use Core\Modules\ShoppingCart\Rules\CalculateCartRule;

class CalculateCartRulesets
{
    public function __construct(private readonly CalculateCartRule $rule)
    {

    }

    public function apply(): CalculateCartOutput
    {
        return new CalculateCartOutput(
            new OutputStatus(200, 'Success'),
            $this->rule->apply()
        );
    }
}
