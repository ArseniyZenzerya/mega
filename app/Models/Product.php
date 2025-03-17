<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Builder;

    class Product extends Model
    {
        use HasFactory;

        protected $fillable = [
            'name',
            'price',
            'description',
            'stock',
            'image',
        ];

        public static function filter(array $filters): Builder
        {
            $query = self::query();

            if (isset($filters['min_price']) && $filters['min_price'] >= 0) {
                $query->where('price', '>=', $filters['min_price']);
            }

            if (isset($filters['max_price']) && $filters['max_price'] >= 0) {
                $query->where('price', '<=', $filters['max_price']);
            }

            if (isset($filters['sort_by'])) {
                switch ($filters['sort_by']) {
                    case 'name':
                        $query->orderBy('name');
                        break;
                    case 'price':
                        $query->orderBy('price');
                        break;
                    case 'availability':
                        $query->orderBy('stock', 'desc');
                        break;
                }
            }

            if (isset($filters['search']) && $filters['search']) {
                $searchTerm = $filters['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            }

            return $query;
        }
        public function attributes()
        {
            return $this->hasMany(ProductFeature::class);
        }

        public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }


        /**
         * Scope for filtering products based on request parameters.
         */
        public function scopeFilter(Builder $query, array $filters): Builder
        {
            return $query->when($filters['category'] ?? null, fn ($q, $category) => $q->where('category_id', $category))
                ->when($filters['price_min'] ?? null, fn ($q, $price) => $q->where('price', '>=', $price))
                ->when($filters['price_max'] ?? null, fn ($q, $price) => $q->where('price', '<=', $price));
        }

        /**
         * Scope for searching products by name or ID.
         */
        public function scopeSearch(Builder $query, ?string $searchTerm): Builder
        {
            return $query->when($searchTerm, fn ($q) =>
            $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('id', 'like', "%{$searchTerm}%")
            );
        }
    }
