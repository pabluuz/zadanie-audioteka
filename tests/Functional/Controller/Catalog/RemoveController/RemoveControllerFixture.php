<?php

namespace App\Tests\Functional\Controller\Catalog\RemoveController;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RemoveControllerFixture extends AbstractFixture
{

    public const PRODUCT_ID = '0d46b18e-4620-4519-8640-e62ef81b92ec';

    public function load(ObjectManager $manager): void
    {
        $product = new Product(self::PRODUCT_ID, 'Product to remove', 1990);
        $manager->persist($product);
        $manager->flush();
    }
}