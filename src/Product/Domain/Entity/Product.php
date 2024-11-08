<?php

namespace App\Product\Domain\Entity;

readonly class Product
{
    function __construct(
        public string $sku,
        public string $name,
        public string $category, # A enum would be better for that than a string
        public int $price,
    )
    {

    }
}
