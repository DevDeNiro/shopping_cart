<?php

namespace App\Entity;

use App\Repository\CartItemsRepository;
use App\ValueObject\CartItemsId;
use App\ValueObject\CartId;
use App\ValueObject\ProductId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartItemsRepository::class)]
class CartItems
{
    #[ORM\Id]
    #[ORM\Column(type: "cart_items_id")]
    private CartItemsId $id;

    private ?CartId $cart_id = null;
    private ?ProductId $product_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    public function getId(): CartItemsId
    {
        return $this->id;
    }

    public function setId(CartItemsId $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCartId(): ?CartId
    {
        return $this->cart_id;
    }
    
    public function setCartId(CartId $cart_id): static
    {
        $this->cart_id = $cart_id;
    
        return $this;
    }
    
    public function getProductId(): ?ProductId
    {
        return $this->product_id;
    }
    
    public function setProductId(ProductId $product_id): static
    {
        $this->product_id = $product_id;
    
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
