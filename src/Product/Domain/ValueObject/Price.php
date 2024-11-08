<?php

namespace App\Product\Domain\ValueObject;
readonly class Price
{
    function __construct(
        public int $original,
        public int $final,
        public ?int $discountPercentage,
        public string $currency,
    )
    {
    }
}