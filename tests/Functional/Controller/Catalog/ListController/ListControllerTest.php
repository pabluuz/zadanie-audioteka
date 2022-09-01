<?php

namespace App\Tests\Functional\Controller\Catalog\ListController;

use App\Tests\Functional\WebTestCase;

class ListControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new ListControllerFixture());
    }

    public function test_shows_first_page_of_products(): void
    {
        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page' => '/products?page=1',
            'count' => 7,
            'products' => [
                [
                    'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name' => 'Product 1',
                    'price' => 1990,
                ],
                [
                    'id' => '9670ea5b-d940-4593-a2ac-4589be784203',
                    'name' => 'Product 2',
                    'price' => 3990,
                ],
                [
                    'id' => '15e4a636-ef98-445b-86df-46e1cc0e10b5',
                    'name' => 'Product 3',
                    'price' => 4990,
                ],
            ]
        ], $response);
    }

    public function test_shows_middle_page_of_products(): void
    {
        $this->client->request('GET', '/products?page=1');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=0',
            'next_page' => '/products?page=2',
            'count' => 7,
            'products' => [
                [
                    'id' => '00e91390-3af8-4735-bd06-0311e7131757',
                    'name' => 'Product 4',
                    'price' => 5990,
                ],
                [
                    'id' => '0a5d83f1-8c7e-4253-b020-156439f3d3c9',
                    'name' => 'Product 5',
                    'price' => 6990,
                ],
                [
                    'id' => 'e41ac303-11ab-446e-a253-28572278fdbe',
                    'name' => 'Product 6',
                    'price' => 7990,
                ],
            ]
        ], $response);
    }

    public function test_shows_last_page_of_products(): void
    {
        $this->client->request('GET', '/products?page=2');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=1',
            'next_page' => null,
            'count' => 7,
            'products' => [
                [
                    'id' => 'b7747f7b-ae35-4225-af9a-6ecc803ebf0f',
                    'name' => 'Product 7',
                    'price' => 8990,
                ],
            ]
        ], $response);
    }

    public function test_shows_first_page_of_products_if_page_is_set_to_negative_number(): void
    {
        $this->client->request('GET', '/products?page=-1');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page' => '/products?page=1',
            'count' => 7,
            'products' => [
                [
                    'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name' => 'Product 1',
                    'price' => 1990,
                ],
                [
                    'id' => '9670ea5b-d940-4593-a2ac-4589be784203',
                    'name' => 'Product 2',
                    'price' => 3990,
                ],
                [
                    'id' => '15e4a636-ef98-445b-86df-46e1cc0e10b5',
                    'name' => 'Product 3',
                    'price' => 4990,
                ],
            ]
        ], $response);
    }

    public function test_shows_empty_result_set_if_page_is_beyond_number_of_available_pages(): void
    {
        $this->client->request('GET', '/products?page=3');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=2',
            'next_page' => null,
            'count' => 7,
            'products' => []
        ], $response);
    }
}