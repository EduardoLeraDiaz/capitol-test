<?php

namespace App\Tests\Product;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends WebTestCase
{
    const JSON_BODY='[{"sku":"000001","name":"BV Lean leather ankle boots","category":"boots","price":{"original":89000,"final":26700,"discount_percentage":30,"currency":"EUR"}},{"sku":"000002","name":"BV Lean leather ankle boots","category":"boots","price":{"original":99000,"final":29700,"discount_percentage":30,"currency":"EUR"}},{"sku":"000003","name":"Ashlington leather ankle boots","category":"boots","price":{"original":71000,"final":21300,"discount_percentage":30,"currency":"EUR"}},{"sku":"000004","name":"Naima embellished suede sandals","category":"sandals","price":{"original":79500,"final":0,"discount_percentage":null,"currency":"EUR"}},{"sku":"000005","name":"Nathane leather sneakers","category":"sneakers","price":{"original":59000,"final":0,"discount_percentage":null,"currency":"EUR"}}]';
    const JSON_BODY_FILTERED_BY_SANDALS='[{"sku":"000004","name":"Naima embellished suede sandals","category":"sandals","price":{"original":79500,"final":0,"discount_percentage":null,"currency":"EUR"}}]';
    const JSON_BODY_FILTERED_BY_BOOTS_AND_PRICE_TOP_90000 = '[{"sku":"000001","name":"BV Lean leather ankle boots","category":"boots","price":{"original":89000,"final":26700,"discount_percentage":30,"currency":"EUR"}},{"sku":"000003","name":"Ashlington leather ankle boots","category":"boots","price":{"original":71000,"final":21300,"discount_percentage":30,"currency":"EUR"}}]';
    public function testGetTheListOfProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products');
        $body = $client->getResponse()->getContent();
        $this->assertJson($body);
        $this->assertEquals(self::JSON_BODY, $body);
        $this->assertResponseIsSuccessful();

    }

    public function testGetTheListOfProductsFilteredByCategory(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products',['category'=>'sandals']);
        $body = $client->getResponse()->getContent();
        $this->assertJson($body);
        $this->assertEquals(self::JSON_BODY_FILTERED_BY_SANDALS, $body);
        $this->assertResponseIsSuccessful();
    }

    public function testGetTheListOfProductsFilteredByCategoryAndPrice(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products',['category'=>'boots', 'priceLessThan'=>'90000']);
        $body = $client->getResponse()->getContent();
        $this->assertJson($body);
        $this->assertEquals(self::JSON_BODY_FILTERED_BY_BOOTS_AND_PRICE_TOP_90000, $body);
        $this->assertResponseIsSuccessful();
    }

    public function testGetTheListOfProductsWithWrongPriceFilter(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products',['category'=>'boots', 'priceLessThan'=>'0']);
        $body = $client->getResponse()->getContent();
        $this->assertJson($body);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}