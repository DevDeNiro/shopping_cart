<?php

namespace App\QueryHandler;

use App\Query\GetCartQuery;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetCartQueryHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetCartQuery $query)
    {
        $repository = $this->entityManager->getRepository(Cart::class);
        $cart = $repository->findOneBy(['session_id' => $query->getSessionId()]);

        return $cart;
    }
}