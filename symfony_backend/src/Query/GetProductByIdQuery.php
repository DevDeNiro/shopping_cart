<?php
namespace App\Query;

use App\ValueObject\ProductId;

class GetProductByIdQuery
{
    private ProductId $id;

    public function __construct(ProductId $id)
    {
        $this->id = $id;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }
}