<?php
namespace App\CommandHandler;

use App\Command\UpdateCartItemQuantityCommand;
use App\Repository\CartItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCartItemQuantityCommandHandler implements MessageHandlerInterface
{
    private CartItemsRepository $cartItemRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CartItemsRepository $cartItemRepository, EntityManagerInterface $entityManager)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateCartItemQuantityCommand $command)
    {
        $cartItem = $this->cartItemRepository->find($command->getCartItemsId());

        if (!$cartItem) {
            throw new \Exception('Cart item not found');
        }

        $newQuantity = $cartItem->getQuantity() + $command->getQuantity();

        if ($newQuantity < 0) {
            throw new \Exception('Quantity cannot be less than 0');
        }

        $cartItem->setQuantity($newQuantity);
        $this->entityManager->flush();
    }
}