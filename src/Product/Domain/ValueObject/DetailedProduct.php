<?php

namespace App\Product\Domain\ValueObject;

use App\Product\Domain\Entity\Product;
use JsonSerializable;

readonly class DetailedProduct implements JsonSerializable
{
    public function __construct(
        public Product $product,
        public Price $price,
    )
    {
    }


    public function jsonSerialize(): mixed
    {
        return [
            'sku' => $this->product->sku,
            'name' => $this->product->name,
            'category' => $this->product->category,
            'price' => [
                'original'=> $this->price->original,
                'final'=> $this->price->final,
                'discount_percentage'=> $this->price->discountPercentage,
                'currency'=> $this->price->currency,
            ]
        ];
    }
}