<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private int $id;

  #[ORM\Column(type: 'string', length: 255)]
  private string $name;
  #[ORM\Column(type: 'string', length: 255)]
  private string $slug;

  public function __construct()
  {
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
   * @param mixed $slug
   */
  public function setSlug($slug): self
  {
    $this->slug = $slug;
    return $this;
  }
}
