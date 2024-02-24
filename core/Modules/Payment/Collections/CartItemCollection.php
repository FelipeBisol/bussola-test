<?php

namespace Core\Modules\Payment\Collections;

use Core\Modules\Payment\Entities\CartItem;
use Traversable;

class CartItemCollection implements \IteratorAggregate
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(CartItem $item): void
    {
        $this->items[] = $item;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }
}
