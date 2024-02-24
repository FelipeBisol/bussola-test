<?php

namespace Core\Modules\Payment\Entities;

class CreditCard
{
    public function __construct(
        private readonly string $owner_name,
        private readonly string $number,
        private readonly string $due_date,
        private readonly string $security_code
    )
    {

    }

    public function getOwnerName(): string
    {
        return $this->owner_name;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDueDate(): string
    {
        return $this->due_date;
    }

    public function getSecurityCode(): string
    {
        return $this->security_code;
    }
}
