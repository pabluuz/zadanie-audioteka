<?php

namespace App\Service\Catalog;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;
}
