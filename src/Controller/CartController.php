<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
  #[Route('/cart', name: 'get_cart', methods: ['GET'])]
  final public function getCart(EntityManagerInterface $em): JsonResponse
  {
    $cart = $em->getRepository(Cart::class)->findOneBy(['isActive' => true]);

    if (!$cart || $cart->getItems()->isEmpty()) {
      return $this->json(['message' => 'Cart is empty.'], 200);
    }

    $cartItems = [];
    foreach ($cart->getItems() as $item) {
      $cartItems[] = [
        'product' => $item->getProduct()->getTitle(),
        'price' => $item->getProduct()->getPrice(),
        'quantity' => $item->getQuantity(),
        'total' => $item->getProduct()->getPrice() * $item->getQuantity(),
      ];
    }

    return $this->json($cartItems);
  }

  #[Route('/cart/add', name: 'add_to_cart', methods: ['POST'])]
  public function addToCart(Request $request, EntityManagerInterface $em): JsonResponse
  {
    $data = json_decode($request->getContent(), true);
    $product = $em->getRepository(Product::class)->find($data['product_id']);

    if (!$product) {
      return $this->json(['error' => 'Product not found'], 404);
    }

    $cart = $em->getRepository(Cart::class)->findOneBy(['isActive' => true]);

    // Create new cart if it doesn't exist
    if (!$cart) {
      $cart = new Cart();
      $em->persist($cart);
    }

    // Check if the product already exists in the cart
    $cartItem = $em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'product' => $product]);

    if ($cartItem) {
      $cartItem->setQuantity($cartItem->getQuantity() + 1);
    } else {
      $cartItem = new CartItem();
      $cartItem->setCart($cart)
        ->setProduct($product)
        ->setQuantity(1);
      $em->persist($cartItem);
    }

    $em->flush();

    return $this->json(['message' => 'Product added to cart successfully']);
  }

  #[Route('/cart/remove', name: 'remove_from_cart', methods: ['POST'])]
  public function removeFromCart(Request $request, EntityManagerInterface $em): JsonResponse
  {
    $data = json_decode($request->getContent(), true);
    $product = $em->getRepository(Product::class)->find($data['product_id']);

    if (!$product) {
      return $this->json(['error' => 'Product not found'], 404);
    }

    $cart = $em->getRepository(Cart::class)->findOneBy(['isActive' => true]);

    if (!$cart) {
      return $this->json(['error' => 'Cart not found'], 404);
    }

    $cartItem = $em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'product' => $product]);

    if (!$cartItem) {
      return $this->json(['error' => 'Product not in cart'], 404);
    }

    if ($cartItem->getQuantity() > 1) {
      $cartItem->setQuantity($cartItem->getQuantity() - 1);
    } else {
      $em->remove($cartItem);
    }

    $em->flush();

    return $this->json(['message' => 'Product removed from cart successfully']);
  }
}
