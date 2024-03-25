<?php

namespace Core\Modules\Payment\Outputs;

use Core\Modules\Payment\Collections\PaymentResponseCollection;
use Core\Modules\Payment\Interfaces\OutputInterface;
use Core\Modules\Payment\Presenters\Outputs\ProcessPaymentPresenter;
use Core\Modules\Payment\Presenters\PresenterInterface;

class ProcessPaymentOutput implements OutputInterface
{
    public function __construct(readonly OutputStatus $status, readonly PaymentResponseCollection $data)
    {

    }

    public function getStatus(): OutputStatus
    {
        return $this->status;
    }

    public function getPresenter(): PresenterInterface
    {
        return (new ProcessPaymentPresenter($this))->present();
    }

    public function getData(): PaymentResponseCollection
    {
        return $this->data;
    }
}
