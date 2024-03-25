<?php

namespace Core\Modules\Payment\Enums;

enum PaymentEnum: string
{
    case Pix = 'PIX';
    case CreditCard = 'CreditCard';
    case CreditCardCash = 'CreditCardCash';
}
