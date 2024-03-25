<?php

namespace App\Entities;

class CartItem
{
    public function __construct(private readonly string $name, private readonly int $price, private readonly int $quantity)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
