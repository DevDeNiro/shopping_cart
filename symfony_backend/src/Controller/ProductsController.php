<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/api/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, requirements={"trailingSlash"="/?$"})
     */
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine->getRepository(Products::class)->findAll();

        return new JsonResponse($products, Response::HTTP_OK);
    }
}
