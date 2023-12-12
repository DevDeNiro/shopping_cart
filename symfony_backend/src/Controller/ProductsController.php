<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class ProductsController extends AbstractController
{
    #[Route('/api/products', name: 'Product List', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine->getRepository(Products::class)->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
