<?php

namespace Core\Modules\Payment\Resolvers;

use Core\Modules\Payment\Entities\CreditCard;
use Core\Modules\Payment\Entities\CreditCardCash;
use Core\Modules\Payment\Entities\Pix;
use Core\Modules\Payment\Enums\PaymentEnum;
use Core\Modules\Payment\Inputs\PayerInput;
use Core\Modules\Payment\Interfaces\CalculateTotalOrder;
use Core\Modules\Payment\Interfaces\PaymentEntityInterface;
use Core\Modules\Payment\Strategy\AddedCreditCard;
use Core\Modules\Payment\Strategy\DiscountCreditCardCash;
use Core\Modules\Payment\Strategy\DiscountPix;

class PaymentTypeResolver
{
    public static function resolve(PaymentEnum $paymentType, PayerInput $payerInput): PaymentEntityInterface
    {
        return match ($paymentType){
            PaymentEnum::Pix => new Pix($payerInput),
            PaymentEnum::CreditCardCash => new CreditCardCash($payerInput),
            PaymentEnum::CreditCard => new CreditCard($payerInput),
        };
    }
}
