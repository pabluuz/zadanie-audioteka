<?php

namespace App\Service\Cart;

use App\Service\Catalog\Product;

interface CartService
{
    public function addProduct(string $cartId, string $productId): void;

    public function removeProduct(string $cartId, string $productId): void;

    public function create(): Cart;
}