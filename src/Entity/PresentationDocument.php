<?php

namespace App\Entity;

use App\Repository\PresentationDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationDocumentRepository::class)]
#[ORM\Table(name: "presentation_document")]
class PresentationDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CatalogPresentation::class)]
    private ?CatalogPresentation $product = null;

    #[ORM\Column(length: 255)]
    private ?string $file = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $ty�pe): static
    {
        $this->type = $ty�pe;

        return $this;
    }
}
