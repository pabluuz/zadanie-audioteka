<?php

namespace App\Messenger;

class RemoveProductFromCatalog
{
    public function __construct(public readonly string $productId) {}
}