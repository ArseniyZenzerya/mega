<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CartItem extends Model
    {
        use HasFactory;

        protected $fillable = [
            'user_id',
            'product_id',
            'quantity',
        ];

        public function product()
        {
            return $this->belongsTo(Product::class);
        }

        /**
         * Get a specific cart item for a user.
         */
        public static function getCartItem(int $userId, int $productId): ?self
        {
            return self::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
        }
    }
