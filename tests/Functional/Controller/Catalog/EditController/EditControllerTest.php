<?php

namespace App\Tests\Functional\Controller\Catalog\EditController;

use App\Tests\Functional\WebTestCase;

class EditControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new EditControllerFixture());
    }

    public function test_edits_product(): void
    {
        $this->client->request('PUT', '/products/'.EditControllerFixture::PRODUCT_ID, [
            'name' => 'Product name edited',
            'price' => 2000,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product name edited', $response['products'][0]['name']);
        self::assertequals(2000, $response['products'][0]['price']);
    }

    public function test_cannot_edit_non_existing_product(): void
    {
        $this->client->request('PUT', '/products/00000000-0000-0000-0000-000000000000', [
            'name' => 'Product name edited',
            'price' => 2000,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid product.', $response['error_message']);
    }

    /**
     * @dataProvider cannot_edit_product_name_to_empty_provider
     */
    public function test_cannot_edit_product_name_to_empty($name): void
    {
        $this->client->request('PUT', '/products/'.EditControllerFixture::PRODUCT_ID, [
            'name' => $name,
            'price' => 2000,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }
    /**
     * @dataProvider cannot_edit_product_with_invalid_price_provider
     */
    public function test_cannot_edit_product_with_invalid_price($price): void
    {
        $this->client->request('POST', '/products', [
            'name' => 'Product name',
            'price' => $price,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function cannot_edit_product_name_to_empty_provider()
    {
        return [[''],[' '],[null]];
    }

    public function cannot_edit_product_with_invalid_price_provider()
    {
        return [[''],[0],[-1]];
    }
}