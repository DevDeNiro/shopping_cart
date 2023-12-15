<?php
namespace App\Command;

use App\ValueObject\CartItemsId;

class UpdateCartItemQuantityCommand
{
    private CartItemsId $cartItemsId;
    private int $quantity;

    public function __construct(CartItemsId $cartItemsId, int $quantity)
    {
        $this->cartItemsId = $cartItemsId;
        $this->quantity = $quantity;
    }

    public function getCartItemsId(): CartItemsId
    {
        return $this->cartItemsId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}