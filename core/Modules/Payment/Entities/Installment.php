<?php

namespace Core\Modules\Payment\Entities;

use Core\Modules\Payment\Exceptions\InstallmentException;

class Installment
{
    private int $installment;

    /**
     * @throws InstallmentException
     */
    public function __construct(int $installment)
    {
        if ($installment < 2 || $installment > 12){
            throw new InstallmentException('Número de parcelas é inválido!');
        }
        $this->installment = $installment;
    }

    /**
     * @return int
     */
    public function getInstallment(): int
    {
        return $this->installment;
    }
}
