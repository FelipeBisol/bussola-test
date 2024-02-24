<?php

namespace Core\Enum;

enum PaymentMethod
{
    case Pix;
    case CreditCash;
    case CreditCard;

    public function getName(): string
    {
        return match ($this){
            self::Pix => 'PIX',
            self::CreditCash => 'Cartão de Crédito - à vista',
            self::CreditCard => 'Cartão de Crédito'
        };
    }
}
