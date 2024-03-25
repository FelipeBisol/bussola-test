<?php

namespace Core\Modules\Payment\Resolvers;

use App\Entities\Teste;
use Core\Modules\Payment\Enums\PaymentEnum;
use Core\Modules\Payment\Interfaces\CalculateTotalOrder;
use Core\Modules\Payment\Strategy\AddedCreditCard;
use Core\Modules\Payment\Strategy\DiscountCreditCardCash;
use Core\Modules\Payment\Strategy\DiscountPix;
use Illuminate\Support\Facades\Log;

class CalculateTotalResolver
{
    public static function resolve(PaymentEnum $paymentType, int $installments): CalculateTotalOrder
    {
        return match ($paymentType){
            PaymentEnum::Pix => new DiscountPix(),
            PaymentEnum::CreditCardCash => new DiscountCreditCardCash(),
            PaymentEnum::CreditCard => (new AddedCreditCard())->setInstallments($installments),
        };
    }
}
