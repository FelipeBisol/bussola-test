<?php

namespace Core\Modules\ShoppingCart\Inputs;

class ItemCartIdInput
{
    public function __construct(readonly int $id)
    {

    }

    public function getId(): int
    {
        return $this->id;
    }
}
