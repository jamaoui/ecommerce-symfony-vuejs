<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
  operations: [
    new Get(),
    new GetCollection(),
    new Post(),
  ]
)]
#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(type: 'boolean')]
  private bool $isActive = true;

  #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', cascade: ['persist', 'remove'])]
  private Collection $items;

  public function __construct()
  {
    $this->items = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function isActive(): bool
  {
    return $this->isActive;
  }

  public function setActive(bool $isActive): self
  {
    $this->isActive = $isActive;
    return $this;
  }

  /**
   * @return Collection|CartItem[]
   */
  public function getItems(): Collection
  {
    return $this->items;
  }

  public function addItem(CartItem $item): self
  {
    if (!$this->items->contains($item)) {
      $this->items[] = $item;
      $item->setCart($this);
    }

    return $this;
  }

  public function removeItem(CartItem $item): self
  {
    if ($this->items->removeElement($item)) {
      if ($item->getCart() === $this) {
        $item->setCart(null);
      }
    }

    return $this;
  }
}
