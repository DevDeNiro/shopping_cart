<?php

namespace App\CommandHandler;

use App\Command\AddItemToCartCommand;
use App\Entity\Cart;
use App\Entity\CartItems;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddItemToCartCommandHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(AddItemToCartCommand $command)
    {
        $cartRepository = $this->entityManager->getRepository(Cart::class);
        $productRepository = $this->entityManager->getRepository(Products::class);
        $cartItemRepository = $this->entityManager->getRepository(CartItems::class);

        $cart = $cartRepository->findOneBy(['session_id' => $command->getSessionId()]);
        $product = $productRepository->find($command->getProductId());

        if (!$cart) {
            throw new \Exception('Cart not found');
        }

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cartItem = $cartItemRepository->findOneBy(['cart_id' => $cart, 'product_id' => $product]);

        if ($cartItem) {
            // If the product is already in the cart, increment its quantity.
            $cartItem->setQuantity($cartItem->getQuantity() + $command->getQuantity());
        } else {
            // If the product is not in the cart, add it.
            $cartItem = new CartItems();
            $cartItem->setCartId($cart);
            $cartItem->setProductId($product);
            $cartItem->setQuantity($command->getQuantity());

            $this->entityManager->persist($cartItem);
        }

        $this->entityManager->flush();
    }
}