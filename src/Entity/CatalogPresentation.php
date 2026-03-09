<?php

namespace App\Entity;

use App\Repository\CatalogPresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogPresentationRepository::class)]
class CatalogPresentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'products')]
    private ?Customer $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    /**
     * @var Collection<int, CatalogPresentationComponent>
     */
    #[ORM\OneToMany(targetEntity: CatalogPresentationComponent::class, mappedBy: 'product')]
    private Collection $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): static
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
}
