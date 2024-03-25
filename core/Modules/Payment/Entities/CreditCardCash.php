<?php

namespace Core\Modules\Payment\Entities;

use Core\Modules\Payment\Inputs\PayerInput;
use Core\Modules\Payment\Interfaces\PaymentEntityInterface;

class CreditCardCash implements PaymentEntityInterface
{
    public readonly string $document;

    public function __construct(PayerInput $payerInput)
    {
        $this->document = $payerInput->getDocument();
    }
}
