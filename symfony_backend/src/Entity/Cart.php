<?php

namespace App\Entity;

use App\Repository\CartRepository;
use App\ValueObject\CartId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\Column(type: "cart_id")]
    private CartId $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $session_id = null;

    public function getId(): CartId
    {
        return $this->id;
    }

    public function setId(CartId $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->session_id;
    }

    public function setSessionId(?string $session_id): static
    {
        $this->session_id = $session_id;

        return $this;
    }
}
