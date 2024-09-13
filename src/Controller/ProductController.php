<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
  #[Route('/', name: 'get_products', methods: ['GET'])]
  public function getProducts(ProductRepository $productRepository, SerializerInterface $serializer): Response
  {
    $products = $productRepository->findAll();
    $data = $serializer->normalize($products);
    return $this->render('home.html.twig', [
      'products' => $data,
    ]);
  }

}
