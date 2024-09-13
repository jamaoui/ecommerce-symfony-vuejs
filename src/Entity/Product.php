<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new GetCollection()
  ],
  paginationEnabled: true
)]
#[ApiFilter(SearchFilter::class, properties: [
  'title' => 'partial',
])]
class Product
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 255)]
  #[Groups('product:read')]
  private string $title;

  #[ORM\Column(type: 'decimal', scale: 2)]
  #[Groups('product:read')]
  private float $price;

  #[ORM\Column(type: 'text', nullable: true)]
  #[Groups('product:read')]
  private ?string $description;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  #[Groups('product:read')]
  private ?string $image;
  #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
  private Category $category;

  public function getCategory(): ?Category
  {
    return $this->category;
  }

  public function setCategory(?Category $category): self
  {
    $this->category = $category;

    return $this;
  }

  // Getters and Setters

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;
    return $this;
  }

  public function getPrice(): float
  {
    return $this->price;
  }

  public function setPrice(float $price): self
  {
    $this->price = $price;
    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;
    return $this;
  }

  public function getImage(): ?string
  {
    return $this->image;
  }

  public function setImage(?string $image): self
  {
    $this->image = $image;
    return $this;
  }
}
