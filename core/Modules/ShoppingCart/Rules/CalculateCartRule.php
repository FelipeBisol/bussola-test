<?php

namespace Core\Modules\ShoppingCart\Rules;

use App\Entities\Cart;
use Core\Modules\ShoppingCart\Collections\CartCollection;
use Core\Modules\ShoppingCart\Gateway\CartItemRepositoryInterface;
use Core\Modules\ShoppingCart\Inputs\ItemCartIdInput;

class CalculateCartRule
{
    public function __construct(readonly CartItemRepositoryInterface $cartItemRepository, readonly ItemCartIdInput $cartIdInput)
    {
    }

    public function apply(): CartCollection
    {
        $cart = new Cart($this->cartItemRepository->getCartItem($this->cartIdInput->getId()));
        $amount = 0;

        foreach ($cart->items->getIterator() as $item) {
            $amount += $item->getPrice() * $item->getQuantity();
        }

        $cart->setAmount($amount);

        $collection = new CartCollection();
        $collection->add($cart);

        return $collection;
    }
}
