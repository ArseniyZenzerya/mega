<?php

    namespace App\Services;

    use App\Models\Product;
    use Illuminate\Pagination\LengthAwarePaginator;

    class CatalogService
    {
        /**
         * Get filtered products.
         */
        public function getFilteredProducts(array $filters): LengthAwarePaginator
        {
            return Product::filter($filters)->paginate(9);
        }

        /**
         * Search products by name or ID.
         */
        public function searchProducts(?string $query): LengthAwarePaginator
        {
            return Product::search($query)->paginate(10);
        }
    }
