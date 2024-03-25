<?php

namespace Core\Modules\ShoppingCart\Outputs;

use Core\Modules\ShoppingCart\Collections\CartCollection;
use Core\Modules\ShoppingCart\Presenters\Outputs\CalculateCartPresenter;
use Core\Modules\ShoppingCart\Presenters\PresenterInterface;

class CalculateCartOutput implements OutputInterface
{
    public function __construct(
        private readonly OutputStatus $status,
        private readonly CartCollection $data,
    ) {
    }

    public function getPresenter(): PresenterInterface
    {
        return (new CalculateCartPresenter($this))->present();
    }

    public function getData(): CartCollection
    {
        return $this->data;
    }

    public function getStatus(): OutputStatus
    {
        return $this->status;
    }
}
