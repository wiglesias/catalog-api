<?php

namespace App\Entity;

use App\Repository\CatalogPresentationComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogPresentationComponentRepository::class)]
#[ORM\Table(name: "catalog_presentation_component")]
class CatalogPresentationComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CatalogPresentation::class, inversedBy: 'components')]
    private ?CatalogPresentation $product = null;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    private ?Article $article = null;

    #[ORM\Column(type: Types::FLOAT, precision: 10, scale: 4)]
    private ?float $quantity = null;

    #[ORM\Column(length: 10)]
    private ?string $unit = null;

    #[ORM\Column(type: Types::INTEGER)]
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
}
