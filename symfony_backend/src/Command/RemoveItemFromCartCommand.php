<?php
namespace App\Command;

use App\ValueObject\CartItemsId;

class RemoveItemFromCartCommand
{
    private CartItemsId $cartItemsId;

    public function __construct(CartItemsId $cartItemsId)
    {
        $this->cartItemsId = $cartItemsId;
    }

    public function getCartItemsId(): CartItemsId
    {
        return $this->cartItemsId;
    }
}