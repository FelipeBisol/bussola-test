<?php

namespace Core\Modules\Payment\Entities;

use Core\Modules\Payment\Collections\CartItemCollection;

class Cart
{
    public readonly CartItemCollection $items;

    public function __construct(CartItemCollection $items)
    {
        $this->items = $items;
    }
}
