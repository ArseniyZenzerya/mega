<?php

    namespace App\Services;

    use App\Models\Product;
    use Illuminate\Support\Facades\Storage;

    class ProductService
    {
        public function getAllProducts()
        {
            return Product::all();
        }

        public function createProduct(array $data): void
        {
            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('products', 'public');
            }
            Product::create($data);
        }

        public function updateProduct(Product $product, array $data): void
        {
            if (isset($data['image'])) {
                if ($product->image) {
                    Storage::delete($product->image);
                }
                $data['image'] = $data['image']->store('products', 'public');
            }
            $product->update($data);
        }

        public function deleteProduct(Product $product): void
        {
            if ($product->image) {
                Storage::delete($product->image);
            }
            $product->delete();
        }
    }
