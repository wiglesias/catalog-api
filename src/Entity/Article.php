<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Enum\ArticleType;
use App\Enum\UnitType;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['article:read']],
    denormalizationContext: ['groups' => ['article:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'code' => 'partial',
    'name' => 'partial'
])]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: "article")]
class Article
{
    use TimestampableEntity;
    use BlameableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:read','product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['article:read','article:write','product:read'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read','article:write','product:read'])]
    private ?string $name = null;

    #[ORM\Column(enumType: UnitType::class)]
    #[Groups(['article:read','article:write'])]
    private ?UnitType $unit = null;

    #[ORM\Column(type: Types::STRING, enumType: ArticleType::class)]
    #[Groups(['article:read','article:write'])]
    private ?ArticleType $type = null;

    #[ORM\Column(options: ['default' => true])]
    #[Groups(['article:read','article:write'])]
    private ?bool $active = true;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?string $barcode = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?float $netWeight = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?float $grossWeight = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?float $length = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?float $width = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read','article:write'])]
    private ?float $height = null;

    #[ORM\Column(options: ['default' => true])]
    #[Groups(['article:read','article:write'])]
    private ?bool $trackStock = true;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUnit(): ?UnitType
    {
        return $this->unit;
    }

    public function setUnit(UnitType $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getType(): ?ArticleType
    {
        return $this->type;
    }

    public function setType(ArticleType $type): static
    {
        $this->type = $type;

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

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getNetWeight(): ?float
    {
        return $this->netWeight;
    }

    public function setNetWeight(?float $netWeight): static
    {
        $this->netWeight = $netWeight;

        return $this;
    }

    public function getGrossWeight(): ?float
    {
        return $this->grossWeight;
    }

    public function setGrossWeight(?float $grossWeight): static
    {
        $this->grossWeight = $grossWeight;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(?float $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function isTrackStock(): ?bool
    {
        return $this->trackStock;
    }

    public function setTrackStock(bool $trackStock): static
    {
        $this->trackStock = $trackStock;

        return $this;
    }

    public function __toString(): string
    {
        return $this->code.' - '.$this->name ?? '---';
    }
}
