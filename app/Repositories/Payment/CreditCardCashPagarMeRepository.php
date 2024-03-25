<?php

namespace App\Repositories\Payment;

use Core\Modules\Payment\Collections\PaymentResponseCollection;
use Core\Modules\Payment\Entities\Pix;
use Core\Modules\Payment\Gateway\PaymentProcess;
use Core\Modules\Payment\Interfaces\PaymentEntityInterface;

class CreditCardCashPagarMeRepository implements PaymentProcess
{

    /**
     * @param Pix $entity
     * @param float $total
     * @return void
     */

    private array $apiResponse;
    private float $total;

    public function process(PaymentEntityInterface $entity, float $total): void
    {
        //conectar e enviar para api
        $this->total = $total;
        $this->apiResponse = [
            'total' => $total
        ];
    }

    public function getResponse(): PaymentResponseCollection
    {
        return new PaymentResponseCollection(200, 'success', $this->apiResponse);
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
