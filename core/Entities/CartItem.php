<?php

namespace Core\Entities;

class CartItem
{
    private readonly string $name;
    private readonly int $price;
    private readonly int $quantity;

    public function __construct(string $name, int $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
