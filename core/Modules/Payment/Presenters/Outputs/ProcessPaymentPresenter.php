<?php

namespace Core\Modules\Payment\Presenters\Outputs;

use Core\Modules\Payment\Outputs\ProcessPaymentOutput;
use Core\Modules\Payment\Presenters\PresenterInterface;

class ProcessPaymentPresenter implements PresenterInterface
{
    private array $presenter;

    public function __construct(private readonly ProcessPaymentOutput $output)
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
                'api_response' => [
                    'message' => $this->output->getData()->getMessage(),
                    'status' => $this->output->getData()->getStatus(),
                    'data' => $this->output->getData()->getData(),
                ]
            ]
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}
