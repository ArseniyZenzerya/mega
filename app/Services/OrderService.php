<?php

    namespace App\Services;

    use App\Models\CartItem;
    use App\Models\Order;
    use App\Models\OrderItem;
    use Illuminate\Support\Facades\DB;

    class OrderService
    {
        public function placeOrder(int $userId, array $data): Order
        {
            return DB::transaction(function () use ($userId, $data) {
                $cartItems = CartItem::where('user_id', $userId)->get();
                $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

                $order = Order::create([
                    'user_id' => $userId,
                    'status' => 'new',
                    'total_amount' => $totalAmount,
                    'delivery_method' => $data['delivery_method'],
                    'payment_method' => $data['payment_method'],
                ]);

                foreach ($cartItems as $item) {
                    $product = $item->product;

                    if ($product->stock < $item->quantity) {
                        throw new \Exception("Товара '{$product->name}' недостаточно на складе.");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                        'price' => $product->price,
                    ]);

                    $product->decrement('stock', $item->quantity);
                }

                CartItem::where('user_id', $userId)->delete();

                return $order;
            });
        }


        /**
         * Updates the status of an order.
         */
        public function updateOrderStatus(Order $order, string $status): void
        {
            $order->update(['status' => $status]);
        }
    }
