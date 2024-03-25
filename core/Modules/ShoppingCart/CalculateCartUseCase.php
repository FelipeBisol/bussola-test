<?php

namespace Core\Modules\ShoppingCart;

use Core\Modules\ShoppingCart\Gateway\CartItemRepositoryInterface;
use Core\Modules\ShoppingCart\Inputs\ItemCartIdInput;
use Core\Modules\ShoppingCart\Outputs\OutputInterface;
use Core\Modules\ShoppingCart\Rules\CalculateCartRule;
use Core\Modules\ShoppingCart\Rulesets\CalculateCartRulesets;

class CalculateCartUseCase
{
    private OutputInterface $output;

    public function __construct(private readonly CartItemRepositoryInterface $cartItemRepository)
    {

    }

    public function execute(ItemCartIdInput $cartIdInput)
    {
        $this->output = (new CalculateCartRulesets(
            new CalculateCartRule($this->cartItemRepository, $cartIdInput),
        ))->apply();
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }
}
