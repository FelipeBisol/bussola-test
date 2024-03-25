<?php

namespace App\Entities;

use Core\Modules\ShoppingCart\Collections\CartItemCollection;

class Cart
{
    public CartItemCollection $items;
    public int $amount;

    public function __construct(CartItemCollection $items)
    {
        $this->items = $items;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
