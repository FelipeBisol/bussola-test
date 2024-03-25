<?php

namespace App\Repositories\CartItem;

use App\Entities\CartItem;
use Core\Modules\ShoppingCart\Collections\CartItemCollection;
use Core\Modules\ShoppingCart\Gateway\CartItemRepositoryInterface;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function getCartItem(int $cartItemId): CartItemCollection
    {
        $collection = new CartItemCollection();

        $items = [
            0 => new CartItem('Fone de ouvido', 5000, 2),
            1 => new CartItem('Base carregadora', 2500, 1),
            2 => new CartItem('Pilhas', 1000, 1)
        ];

        foreach ($items as $item) {
            $collection->add($item);
        }

        return $collection;
    }
}
