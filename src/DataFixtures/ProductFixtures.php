<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductFixtures extends Fixture
{

  public function __construct(private HttpClientInterface $client)
  {
  }

  final public function load(ObjectManager $manager): void
  {
    // Fetch data from the Fake Store API
    $response = $this->client->request('GET', 'https://fakestoreapi.com/products');
    $productsData = $response->toArray();
    $slugger = new AsciiSlugger();
    foreach ($productsData as $productData) {
      $categoryName = $productData['category'];
      $categorySlug = $slugger->slug($categoryName)->toString();
      if (!isset($categories[$categorySlug])) {
        $category = new Category();
        $category->setName($categoryName);
        $category->setSlug($categorySlug);
        $manager->persist($category);
        $categories[$categorySlug] = $category;
      } else {
        $category = $categories[$categorySlug];
      }

      $product = new Product();
      $product->setTitle($productData['title']);
      $product->setPrice($productData['price']);
      $product->setDescription($productData['description']);
      $product->setImage($productData['image']);
      $product->setCategory($category);

      $manager->persist($product);
    }

    $manager->flush();
  }
}
