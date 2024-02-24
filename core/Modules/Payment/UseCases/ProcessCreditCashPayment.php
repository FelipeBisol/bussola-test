<?php

namespace Core\Modules\Payment\UseCases;

use Core\Modules\Payment\Gateway\PaymentProcess;

class ProcessCreditCashPayment extends PaymentProcess
{
    public function getResponse(): string
    {
        $diff = $this->paymentMethod->getOrderValue() - $this->paymentProcessed;

        return "A sua compra recebeu um desconto de: R$ "
            . number_format($diff / 100, 2,',', '.').
            '. Ficando no valor total de: R$ ' . number_format($this->paymentProcessed / 100, 2, ',', '.');
    }
}
