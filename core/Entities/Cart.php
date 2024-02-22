<?php

namespace Core\Entities;

use Core\Collections\CartItemCollection;

class Cart
{
    public readonly CartItemCollection $items;

    public function __construct(CartItemCollection $items)
    {
        $this->items = $items;
    }
}
