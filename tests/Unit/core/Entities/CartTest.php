<?php

namespace Tests\Unit\core\Entities;

use Core\Collections\CartItemCollection;
use Core\Entities\Cart;
use Core\Entities\CartItem;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_must_ensure_that_the_items_in_the_cart_do_not_undergo_changes(): void
    {
        //arrange
        $item1 = $this->createMock(CartItem::class);
        $item1->method('getName')->willReturn('Camiseta G');

        $item2 = $this->createMock(CartItem::class);
        $item2->method('getName')->willReturn('Camiseta M');

        $collection = new CartItemCollection();

        //act
        $collection->add($item1);
        $collection->add($item2);
        $cart = new Cart($collection);

        //assert
        foreach ($cart->items->getIterator() as $key => $item) {
            if ($key === 0) {
                $this->assertEquals($item, $item1);
            } elseif ($key === 1) {
                $this->assertEquals($item, $item2);
            }
        }
    }
}
