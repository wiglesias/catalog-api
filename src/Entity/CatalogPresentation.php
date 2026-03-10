<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CatalogPresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'code' => 'partial',
    'name' => 'partial',
    'catalog.id' => 'exact',
    'customer.slug' => 'exact'
])]
#[ORM\Entity(repositoryClass: CatalogPresentationRepository::class)]
#[ORM\Table(name: "catalog_presentation")]
class CatalogPresentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'products')]
    #[Groups(['product:read','product:write'])]
    private ?Customer $customer = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read','product:write'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read','product:write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['product:read'])]
    private ?int $version = 1;

    /**
     * @var Collection<int, CatalogPresentationComponent>
     */
    #[ORM\OneToMany(targetEntity: CatalogPresentationComponent::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups(['product:read','product:write'])]
    private Collection $components;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['product:read','product:write'])]
    private ?Catalog $catalog = null;

    #[ORM\Column]
    #[Groups(['product:read','product:write'])]
    private ?bool $active = null;

    #[ORM\ManyToOne(targetEntity: CatalogCategory::class)]
    private ?CatalogCategory $category = null;

    /**
     * @var Collection<int, PresentationAttributeValue>
     */
    #[ORM\OneToMany(targetEntity: PresentationAttributeValue::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['product:read','product:write'])]
    private Collection $attributeValues;

    public function __construct()
    {
        $this->components = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
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

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $version): static
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return Collection<int, CatalogPresentationComponent>
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(CatalogPresentationComponent $component): static
    {
        if (!$this->components->contains($component)) {
            $this->components->add($component);
            $component->setProduct($this);
        }

        return $this;
    }

    public function removeComponent(CatalogPresentationComponent $component): static
    {
        if ($this->components->removeElement($component)) {
            // set the owning side to null (unless already changed)
            if ($component->getProduct() === $this) {
                $component->setProduct(null);
            }
        }

        return $this;
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCategory(): ?CatalogCategory
    {
        return $this->category;
    }

    public function setCategory(?CatalogCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, PresentationAttributeValue>
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function addAttributeValue(PresentationAttributeValue $value): static
    {
        if (!$this->attributeValues->contains($value)) {
            $this->attributeValues->add($value);
            $value->setProduct($this);
        }

        return $this;
    }

    public function removeAttributeValue(PresentationAttributeValue $value): static
    {
        if ($this->attributeValues->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getProduct() === $this) {
                $value->setProduct(null);
            }
        }

        return $this;
    }
}
