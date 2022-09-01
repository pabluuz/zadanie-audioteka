<?php

namespace App\Tests\Functional\Controller\Catalog\AddController;


use App\Tests\Functional\WebTestCase;

class AddControllerTest extends WebTestCase
{
    public function test_adds_product(): void
    {
        $this->client->request('POST', '/products', [
            'name' => 'Product name',
            'price' => 1990,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);
        
        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product name', $response['products'][0]['name']);
        self::assertequals(1990, $response['products'][0]['price']);
    }

    public function test_product_with_empty_name_cannot_be_added(): void
    {
        $this->client->request('POST', '/products', [
            'name' => '    ',
            'price' => 1990,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function test_product_without_a_price_cannot_be_added(): void
    {
        $this->client->request('POST', '/products', [
            'name' => 'Product name',
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function test_product_with_non_positive_price_cannot_be_added(): void
    {
        $this->client->request('POST', '/products', [
            'name' => 'Product name',
            'price' => 0,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }
}