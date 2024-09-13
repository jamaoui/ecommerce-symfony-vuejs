<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'items')]
  private Cart $cart;

  #[ORM\ManyToOne(targetEntity: Product::class)]
  private Product $product;

  #[ORM\Column(type: 'integer')]
  private int $quantity;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getCart(): Cart
  {
    return $this->cart;
  }

  public function setCart(?Cart $cart): self
  {
    $this->cart = $cart;
    return $this;
  }

  public function getProduct(): Product
  {
    return $this->product;
  }

  public function setProduct(?Product $product): self
  {
    $this->product = $product;
    return $this;
  }

  public function getQuantity(): int
  {
    return $this->quantity;
  }

  public function setQuantity(int $quantity): self
  {
    $this->quantity = $quantity;
    return $this;
  }
}
