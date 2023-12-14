<?php

namespace App\Doctrine;

use App\ValueObject\CartItemsId;
use DigitalCraftsman\Ids\Doctrine\IdType;

final class CartItemsIdType extends IdType
{
    public function getTypeName(): string
    {
        return 'cart_items_id';
    }

    public function getIdClass(): string
    {
        return CartItemsId::class;
    }
}
