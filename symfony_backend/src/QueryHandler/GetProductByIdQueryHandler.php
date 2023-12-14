<?php

namespace App\QueryHandler;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use App\Query\GetProductByIdQuery;

class GetProductByIdQueryHandler
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(GetProductByIdQuery $query)
    {
        $product = $this->doctrine->getRepository(Products::class)->find($query->getId());

        if (!$product) {
            return null;
        }

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
        ];
    }
}