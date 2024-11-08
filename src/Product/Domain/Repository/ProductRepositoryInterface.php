<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @return array<Product>
     */
    public function list(int $resultPerPage=5, ?string $category=null, ?int $priceLessThan=null): array;
}
