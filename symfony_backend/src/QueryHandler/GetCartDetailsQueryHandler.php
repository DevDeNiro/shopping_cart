<?php

namespace App\QueryHandler;

use App\Query\GetCartDetailsQuery;
use App\Entity\Cart;
use App\Entity\CartItems;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\ValueObject\CartId;
use App\ValueObject\CartItemsId;

class GetCartDetailsQueryHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetCartDetailsQuery $query)
    {
        $cartRepository = $this->entityManager->getRepository(Cart::class);
        $cart = $cartRepository->findOneBy(['session_id' => $query->getSessionId()]);

        if (!$cart) {
            return null;
        }

        $cartItemsRepository = $this->entityManager->getRepository(CartItems::class);
        $cartItems = $cartItemsRepository->findBy(['cart_id' => $cart->getId()]);

        $productRepository = $this->entityManager->getRepository(Products::class);

        return [
            'id' => new CartId((string) $cart->getId()),
            'sessionId' => $cart->getSessionId(),
            'products' => array_map(function ($item) use ($productRepository) {
                $product = $productRepository->find($item->getProductId());
                return [
                    'cartItemId' => new CartItemsId((string) $item->getId()),
                    'productName' => $product ? $product->getName() : null,
                    'price' => $product ? $product->getPrice() : null,
                    'quantity' => $item->getQuantity(),
                ];
            }, $cartItems),
        ];
    }
}
