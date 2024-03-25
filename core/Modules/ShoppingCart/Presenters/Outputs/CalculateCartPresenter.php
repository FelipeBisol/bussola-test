<?php

namespace Core\Modules\ShoppingCart\Presenters\Outputs;

use Core\Modules\ShoppingCart\Outputs\CalculateCartOutput;
use Core\Modules\ShoppingCart\Presenters\PresenterInterface;

class CalculateCartPresenter implements PresenterInterface
{
    private array $presenter;

    public function __construct(private readonly CalculateCartOutput $output)
    {
    }

    public function present(): self
    {
        $status = [
            'status' => [
                'code' => $this->output->getStatus()->getCode(),
                'message' => $this->output->getStatus()->getMessage()
            ],
        ];

        $this->presenter = [
            ...$status,
            'data' => [
                'total' => $this->output->getData()->getFirst()->getAmount()
            ]
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}
