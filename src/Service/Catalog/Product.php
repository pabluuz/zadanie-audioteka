<?php

namespace App\Service\Catalog;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function setName(string $name): void;
    public function getPrice(): int;
    public function setPrice(string $price): void;
    public function getCreated(): \DateTimeImmutable;
}
