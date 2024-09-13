<?php

namespace App\Serializer;

use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use UnexpectedValueException;

class ProductNormalizer implements NormalizerInterface
{
  public function normalize($object, string $format = null, array $context = []): array
  {
    if (!$object instanceof Product) {
      throw new UnexpectedValueException('Object must be of type Product');
    }

    return [
      'id' => $object->getId(),
      'title' => $object->getTitle(),
      'price' => $object->getPrice(),
      'image' => $object->getImage(),
      'category' => $object->getCategory()->getName(),
    ];
  }

  public function supportsNormalization($data, string $format = null, array $context = []): bool
  {
    return $data instanceof Product;
  }

  public function getSupportedTypes(?string $format): array
  {
    return [
      Product::class => true,
    ];
  }
}