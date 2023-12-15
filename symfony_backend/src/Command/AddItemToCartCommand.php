<?php

namespace App\Command;

use App\ValueObject\CartItemsId;
use App\ValueObject\ProductId;

class AddItemToCartCommand
{
    private CartItemsId $id;
    private string $sessionId;
    private ?ProductId $productId = null;
    private int $quantity;

    public function __construct(string $sessionId, ProductId $productId, int $quantity)
    {
        $this->sessionId = $sessionId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getProductId(): ?ProductId
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}