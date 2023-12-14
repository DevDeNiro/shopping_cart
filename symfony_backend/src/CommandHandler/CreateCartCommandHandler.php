<?php

namespace App\CommandHandler;

use App\Command\CreateCartCommand;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCartCommandHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateCartCommand $command)
    {
        $cart = new Cart();
        $cart->setId($command->getId());
        $cart->setSessionId($command->getSessionId());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}