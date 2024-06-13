<?php

namespace App\Services;

use App\Models\Product;
use App\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Collection;

class ProductService extends BaseService
{
    public function __construct(
        private Product $product,
        private ProductFactory $productFactory,
    ) {
    }

    public function createProduct(
        array $data
    ): Product {
        $product = $this->productFactory->create(
            $data['name'],
            $data['price'],
            $data['quantity'],
            $data['description'],
            $data['status'],
            #auth()->user()->id,
            #$data['sku'],
        );

        $this->create($product);

        return $product;
    }

    public function updateProduct(Product $product, array $data)
    {
        $product = $product->fill($data);

        $this->create($product);

        return $product;
    }

    public function getAllProducts($paginate = null): Collection
    {
        return $this->getAll($this->product, $paginate);
    }

    public function get(int $idP): Product
    {
        return $this->getById($idP, $this->product);
    }

    public function deleteProduct($idP): bool
    {
        return $this->delete($idP, $this->product);
    }
}
