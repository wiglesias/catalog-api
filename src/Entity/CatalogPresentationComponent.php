<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CatalogPresentationComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: CatalogPresentationComponentRepository::class)]
#[ORM\Table(name: "catalog_presentation_component")]
class CatalogPresentationComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CatalogPresentation::class, inversedBy: 'components')]
    #[Groups(['product:write'])]
    private ?CatalogPresentation $product = null;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    #[Groups(['product:read','product:write'])]
    private ?Article $article = null;

    #[ORM\Column(type: Types::FLOAT, precision: 10, scale: 4)]
    #[Groups(['product:read','product:write'])]
    private ?float $quantity = null;

    #[ORM\Column(length: 10)]
    #[Groups(['product:read','product:write'])]
    private ?string $unit = null;

    #[Gedmo\SortablePosition]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['product:read','product:write'])]
    private ?int $position = 0;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function __toString(): string
    {
        $code = $this->article?->getCode() ?? '';
        $name = $this->article?->getName() ?? '';
        $quantity = $this->quantity ?? 0;
        $unit = $this->unit ?? '';

        return sprintf('%s - %s - %s - %s', $code, $name, $quantity, $unit);
    }
}
