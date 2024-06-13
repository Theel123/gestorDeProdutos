<?php

namespace App\Factories;

use App\Models\Product;

class ProductFactory
{
    public function create(
        string $name,
        string $price,
        string $quantity,
        string $description,
        string $status,
        # int $userId,
    ): Product {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setQuantity($quantity);
        $product->setDescription($description);
        $product->setStatus($status);
        # $product->setUserId($userId);

        return $product;
    }
}
