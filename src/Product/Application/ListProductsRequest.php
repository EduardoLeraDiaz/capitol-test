<?php

namespace App\Product\Application;

readonly class ListProductsRequest {
    function __construct(
        public ?string $category=null,
        public ?int $priceLessThan=null,
    )
    {
    }
}
