<?php

namespace App\Product\Application;

use App\Product\Domain\ValueObject\DetailedProduct;

readonly class ListProductsResponse
{
    /**
     * @param array<DetailedProduct> $products
     */
    function __construct(public array $products)
    {

    }
}