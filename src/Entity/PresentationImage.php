<?php

namespace App\Entity;

use App\Repository\PresentationImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationImageRepository::class)]
#[ORM\Table(name: "presentation_image")]
class PresentationImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?CatalogPresentation $product = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column]
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

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
