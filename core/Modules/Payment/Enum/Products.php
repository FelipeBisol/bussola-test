<?php

namespace Core\Modules\Payment\Enum;

enum Products
{
    case Camiseta;
    case Colar;
    case Relogio;

    public function getPrice(): int
    {
        return match ($this){
            self::Camiseta => 19990,
            self::Colar => 2990,
            self::Relogio => 25000
        };
    }

    public function getName(): string
    {
        return match ($this){
            self::Camiseta => 'Camiseta',
            self::Colar => 'Colar',
            self::Relogio => 'Relógio'
        };
    }

    public function getPriceFormatted(): string
    {
        return number_format($this->getPrice() / 100, 2, ',', '.');
    }
}
