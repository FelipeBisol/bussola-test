<?php

namespace Core\Modules\Payment\Gateway;

use Core\Modules\Payment\Collections\PaymentResponseCollection;
use Core\Modules\Payment\Interfaces\PaymentEntityInterface;

interface PaymentProcess
{
    public function process(PaymentEntityInterface $entity, float $total): void;

    public function getResponse(): PaymentResponseCollection;

    public function getTotal(): int;
}
