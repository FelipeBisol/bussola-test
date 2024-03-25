<?php

namespace Core\Modules\ShoppingCart\Gateway;

use Core\Modules\ShoppingCart\Collections\CartItemCollection;

interface CartItemRepositoryInterface
{
    public function getCartItem(int $cartItemId): CartItemCollection;
}
