<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PresentationAttributeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: PresentationAttributeRepository::class)]
class PresentationAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['attribute:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['attribute:read','attribute:write'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['attribute:read','attribute:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['attribute:read','attribute:write'])]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
