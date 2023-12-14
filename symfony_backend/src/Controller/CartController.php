<?php

namespace App\Controller;

use App\Command\CreateCartCommand;
use App\Command\AddItemToCartCommand;
use App\Query\GetCartQuery;
use App\ValueObject\CartId;
use App\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CartController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    #[Route('/api/cart', methods: ['POST'])]
    public function createCart(Request $request): Response
    {
        //$sessionId = $request->getSession()->getId();
        $sessionId = $request->headers->get('X-Session-Id');
        $cartId = CartId::fromMixed(uuid_create(UUID_TYPE_RANDOM));

        $command = new CreateCartCommand($cartId, $sessionId);
        $this->commandBus->dispatch($command);

        return $this->json(['id' => $cartId], Response::HTTP_CREATED);
    }

    #[Route('/api/cart', methods: ['GET'])]
    public function getCart(Request $request): Response
    {
        $sessionId = $request->headers->get('X-Session-Id');
        $query = new GetCartQuery($sessionId);
        $cart = $this->commandBus->dispatch($query);

        if (!$cart) {
            return $this->json(['error' => 'Cart not found'], Response::HTTP_NOT_FOUND);
        }

        $envelope = $this->commandBus->dispatch($query);
        $handledStamp = $envelope->last(HandledStamp::class);

        // Check if the handler returned a result.
        if ($handledStamp && $cart = $handledStamp->getResult()) {
            $cartData = [
                'id' => (string) $cart->getId(),
                'sessionId' => $cart->getSessionId(),
                // Add other Cart fields here.
            ];

            return $this->json($cartData);
        }

        return $this->json(['error' => 'Cart not found'], Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/cart/items', methods: ['POST'])]
    public function postCartItems(Request $request): Response
    {
        $sessionId = $request->headers->get('X-Session-Id');
        $data = json_decode($request->getContent(), true);
        $productId = isset($data['productId']) ? new ProductId($data['productId']) : null;
        $quantity = $data['quantity'] ?? 1;

        if (!$productId) {
            return $this->json(['error' => 'Product ID is required'], Response::HTTP_BAD_REQUEST);
        }

        $command = new AddItemToCartCommand($sessionId, $productId, $quantity);
        $this->commandBus->dispatch($command);

        return $this->json(['message' => 'Product added to cart'], Response::HTTP_CREATED);
    }
}