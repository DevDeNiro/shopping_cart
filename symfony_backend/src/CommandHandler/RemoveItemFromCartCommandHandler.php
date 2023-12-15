<?php
namespace App\CommandHandler;

use App\Command\RemoveItemFromCartCommand;
use App\Repository\CartItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveItemFromCartCommandHandler implements MessageHandlerInterface
{
    private CartItemsRepository $cartItemRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CartItemsRepository $cartItemRepository, EntityManagerInterface $entityManager)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(RemoveItemFromCartCommand $command)
    {
        $cartItem = $this->cartItemRepository->find($command->getCartItemsId());

        if (!$cartItem) {
            throw new \Exception('Cart item not found');
        }

        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();
    }
}