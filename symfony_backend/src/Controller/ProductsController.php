<?php

namespace App\Controller;

use App\Query\GetAllProductsQuery;
use App\Query\GetProductByIdQuery;
use App\QueryHandler\GetAllProductsQueryHandler;
use App\QueryHandler\GetProductByIdQueryHandler;
use App\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private $getAllProductsQueryHandler;
    private $getProductByIdQueryHandler;

    public function __construct(
        GetAllProductsQueryHandler $getAllProductsQueryHandler,
        GetProductByIdQueryHandler $getProductByIdQueryHandler
    ) {
        $this->getAllProductsQueryHandler = $getAllProductsQueryHandler;
        $this->getProductByIdQueryHandler = $getProductByIdQueryHandler;
    }

    //Get all products from the database
    #[Route('/api/products', name: 'Product List', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $query = new GetAllProductsQuery();
        $data = ($this->getAllProductsQueryHandler)($query);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    //Get a single product for the given id
    #[Route('/api/products/{id}', name: 'Product Detail', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $productId = new ProductId($id);
        $query = new GetProductByIdQuery($productId);
        $data = ($this->getProductByIdQueryHandler)($query);

        if (!$data) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
