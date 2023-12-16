<?php

namespace App\CommandHandler;

use App\Command\AddItemToCartCommand;
use App\Entity\Cart;
use App\Entity\CartItems;
use App\Entity\Products;
use App\ValueObject\CartId;
use App\ValueObject\ProductId;
use App\ValueObject\CartItemsId;
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

        // Fetch the cart using the session ID
        $cart = $cartRepository->findOneBy(['session_id' => $command->getSessionId()]);
        $product = $productRepository->find($command->getProductId());

        // If the cart or product is not found, throw an exception.
        if (!$cart || !$product) {
            throw new \Exception(!$cart ? 'Cart not found' : 'Product not found');
        }

        $cartItem = $cartItemRepository->findOneBy(['cart_id' => $cart, 'product_id' => $product]);

        if ($cartItem) {
            // If the product is already in the cart, increment its quantity.
            $cartItem->setQuantity($cartItem->getQuantity() + $command->getQuantity());
        } else {
            $cartItem = new CartItems();
            $cartItem->setId(new CartItemsId(uuid_create(UUID_TYPE_RANDOM)));
            $cartItem->setCartId(new CartId($cart->getId()));
            $cartItem->setProductId(new ProductId($product->getId()));
            $cartItem->setQuantity($command->getQuantity());

            $this->entityManager->persist($cartItem);
        }

        $this->entityManager->flush();
    }
}
