<?php

namespace App\Product\Infrastructure\MemoryDB;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;

class MemoryProductRepository implements ProductRepositoryInterface
{
    private const PRODUCTS = [
        [
            "sku" => "000001",
            "name" => "BV Lean leather ankle boots",
            "category" => "boots",
            "price" => 89000
        ],
        [
            "sku" => "000002",
            "name" => "BV Lean leather ankle boots",
            "category" => "boots",
            "price" => 99000
        ],
        [
            "sku" => "000003",
            "name" => "Ashlington leather ankle boots",
            "category" => "boots",
            "price" => 71000
        ],
        [
            "sku" => "000004",
            "name" => "Naima embellished suede sandals",
            "category" => "sandals",
            "price" => 79500
        ],
        [
            "sku" => "000005",
            "name" => "Nathane leather sneakers",
            "category" => "sneakers",
            "price" => 59000
        ]
    ];
    /**
     * @return array<Product>
     */
    public function list(int $resultPerPage=5, ?string $category=null, ?int $priceLessThan=null): array
    {
        $products = [];

        foreach ($this::PRODUCTS as $product) {
            if (!is_null($category) && $product['category'] !== $category) {
                continue;
            }

            if (!is_null($priceLessThan) && $product['price'] > $priceLessThan) {
                continue;
            }

            $products[] = new Product($product['sku'], $product['name'], $product['category'], $product['price']);

            if (count($products) === $resultPerPage) {
                break;
            }
        }

        return $products;
    }
}