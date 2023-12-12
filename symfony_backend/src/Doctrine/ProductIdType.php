<?php

namespace App\Doctrine;

use App\ValueObject\ProductId;
use DigitalCraftsman\Ids\Doctrine\IdType;

final class ProductIdType extends IdType
{
    public function getTypeName(): string
    {
        return 'product_id';
    }

    public function getIdClass(): string
    {
        return ProductId::class;
    }
}
