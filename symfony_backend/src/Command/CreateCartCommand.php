<?php

namespace App\Command;

use App\ValueObject\CartId;

class CreateCartCommand
{
    private CartId $id;
    private string $sessionId;

    public function __construct(CartId $id, string $sessionId)
    {
        $this->id = $id;
        $this->sessionId = $sessionId;
    }

    public function getId(): CartId
    {
        return $this->id;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }
}