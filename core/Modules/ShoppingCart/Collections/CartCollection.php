<?php

namespace Core\Modules\ShoppingCart\Collections;

use App\Entities\Cart;

class CartCollection implements \IteratorAggregate
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(Cart $item): void
    {
        $this->items[] = $item;
    }

    public function getFirst(): Cart
    {
        return $this->getIterator()[0];
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}
