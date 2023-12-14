<?php

namespace App\Doctrine;

use App\ValueObject\CartId;
use DigitalCraftsman\Ids\Doctrine\IdType;

final class CartIdType extends IdType
{
    public function getTypeName(): string
    {
        return 'cart_id';
    }

    public function getIdClass(): string
    {
        return CartId::class;
    }
}
