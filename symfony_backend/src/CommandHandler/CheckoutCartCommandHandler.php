<?php

namespace App\CommandHandler;

use App\Command\CheckoutCartCommand;
use App\Entity\Cart;
use App\Entity\CartItems;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CheckoutCartCommandHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CheckoutCartCommand $command)
    {
        $sessionId = $command->getSessionId();

        // Fetch the cart using the session ID
        $cartRepository = $this->entityManager->getRepository(Cart::class);
        $cart = $cartRepository->findOneBy(['session_id' => $sessionId]);

        if ($cart) {
            // Fetch the cart items using the cart ID
            $cartItemsRepository = $this->entityManager->getRepository(CartItems::class);
            $cartItems = $cartItemsRepository->findBy(['cart_id' => $cart->getId()]);

            // Remove the cart items
            foreach ($cartItems as $item) {
                $this->entityManager->remove($item);
            }
            $this->entityManager->flush();
        }
    }
}
