<?php

namespace Core\Collections;

use Core\Entities\CartItem;
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
