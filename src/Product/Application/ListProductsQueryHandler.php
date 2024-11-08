<?php

namespace App\Product\Application;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\DetailedProduct;
use App\Product\Domain\ValueObject\Price;

readonly class ListProductsQueryHandler
{
    function __construct(
        public ProductRepositoryInterface $productRepository
    )
    {
    }

    function handle(ListProductsRequest $request): ListProductsResponse
    {
        $products = $this->productRepository->list(5, $request->category, $request->priceLessThan);

        $detailedProducts = [];
        foreach ($products as $product) {
            $discount = $this->getDiscount($product);
            $detailedProducts[] = new DetailedProduct(
                $product,
                new Price(
                    $product->price,
                    $product->price * ($discount/100),
                    $discount,
                    'EUR'

                )
            );
        }

        return new ListProductsResponse($detailedProducts);
    }

    # That should be a function in a separate class that handles the discounts thought a rules saved in a DB
    private function getDiscount(Product $product): ?int {
        $discounts = [];
        if ($product->category === 'boots') {
            $discounts[] = 30;
        }

        if ($product->sku === '000003') {
            $discounts[] = 15;
        }

        return count($discounts) === 0 ? null : max($discounts);
    }
}
