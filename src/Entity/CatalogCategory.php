<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CatalogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'catalog.id' => 'exact',
    'slug' => 'exact',
    'name' => 'partial'
])]
#[ORM\Entity(repositoryClass: CatalogCategoryRepository::class)]
#[ORM\Table(
    name: 'catalog_category',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'catalog_slug_unique', columns: ['catalog_id','slug'])
    ]
)]
class CatalogCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read','product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Catalog::class)]
    #[Groups(['category:read', 'category:write'])]
    private ?Catalog $catalog = null;

    #[ORM\Column(length: 150)]
    #[Groups(['category:read','category:write','product:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'category:write'])]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[Groups(['category:read', 'category:write'])]
    private ?CatalogCategory $parent = null;


    /**
     * @var Collection<int, CatalogCategory>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[Groups(['category:read'])]
    private Collection $children;

    #[ORM\Column]
    #[Groups(['category:read','category:write'])]
    private ?bool $active = true;

    /**
     * @var Collection<int, CatalogPresentation>
     */
    #[ORM\OneToMany(targetEntity: CatalogPresentation::class, mappedBy: 'catalogCategory')]
    private Collection $products;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, CatalogPresentation>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(CatalogPresentation $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCatalogCategory($this);
        }

        return $this;
    }

    public function removeProduct(CatalogPresentation $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCatalogCategory() === $this) {
                $product->setCatalogCategory(null);
            }
        }

        return $this;
    }
}
