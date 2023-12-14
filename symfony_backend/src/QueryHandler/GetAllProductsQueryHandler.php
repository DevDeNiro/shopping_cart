<?php
namespace App\QueryHandler;

use App\Entity\Products;
use App\Query\GetAllProductsQuery;
use Doctrine\Persistence\ManagerRegistry;

class GetAllProductsQueryHandler
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(GetAllProductsQuery $query)
    {
        $products = $this->doctrine->getRepository(Products::class)->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
            ];
        }

        return $data;
    }
}