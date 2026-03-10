<?php

namespace App\Entity;

use App\Repository\CatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
#[ORM\Table(name: "catalog")]
class Catalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'catalogs')]
    private ?Customer $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = true;

    /**
     * @var Collection<int, CatalogPresentation>
     */
    #[ORM\OneToMany(targetEntity: CatalogPresentation::class, mappedBy: 'catalog')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $product->setCatalog($this);
        }

        return $this;
    }

    public function removeProduct(CatalogPresentation $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCatalog() === $this) {
                $product->setCatalog(null);
            }
        }

        return $this;
    }
}
