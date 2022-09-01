<?php

namespace App\Service\Cart;

use App\Service\Catalog\Product;

interface Cart
{
    public function getId(): string;
    public function getTotalPrice(): int;
    public function isFull(): bool;
    /**
     * @return Product[]
     */
    public function getProducts(): iterable;
}
