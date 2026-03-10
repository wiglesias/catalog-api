<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CatalogCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']]
)]
#[ORM\Entity(repositoryClass: CatalogCategoryRepository::class)]
class CatalogCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Catalog::class)]
    #[Groups(['category:read', 'category:write'])]
    private ?Catalog $catalog = null;

    #[ORM\Column(length: 150)]
    #[Groups(['category:read', 'category:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'category:write'])]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['category:read', 'category:write'])]
    private ?CatalogCategory $parent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }

    public function setCatalog(?Catalog $catalog): static
    {
        $this->catalog = $catalog;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }
}
