<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PresentationAttributeValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: PresentationAttributeValueRepository::class)]
class PresentationAttributeValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[Groups(['product:write'])]
    private ?CatalogPresentation $product = null;

    #[ORM\ManyToOne]
    #[Groups(['product:read','product:write'])]
    private ?PresentationAttribute $attribute = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read','product:write'])]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?CatalogPresentation
    {
        return $this->product;
    }

    public function setProduct(?CatalogPresentation $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getAttribute(): ?PresentationAttribute
    {
        return $this->attribute;
    }

    public function setAttribute(?PresentationAttribute $attribute): static
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
