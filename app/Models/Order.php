<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Order extends Model
    {
        use HasFactory;

        protected $fillable = [
            'user_id',
            'status',
            'total_amount',
            'delivery_method',
            'payment_method',
            'shipping_address'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }

        public function addOrderItems($cartItems): void
        {
            foreach ($cartItems as $item) {
                $this->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
        }
    }
