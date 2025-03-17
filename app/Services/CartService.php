<?php

    namespace App\Services;

    use App\Models\CartItem;
    use App\Models\Product;
    use Illuminate\Support\Collection;

    class CartService
    {
        /**
         * Retrieve the user's cart items.
         */
        public function getUserCart(int $userId)
        {
            return CartItem::where('user_id', $userId)
                ->with(['product' => function ($query) {
                    $query->select('id', 'name', 'price', 'stock');
                }])
                ->get()
                ->map(function ($item) {
                    $item->available_stock = $item->product->stock;
                    return $item;
                });
        }


        /**
         * Add a product to the cart.
         */
        public function addToCart(int $userId, Product $product): void
        {
            $cartItem = CartItem::getCartItem($userId, $product->id);

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        }

        /**
         * Update the quantity of a product in the cart.
         */
        public function updateCart(int $userId, Product $product, int $quantity): void
        {
            $cartItem = CartItem::getCartItem($userId, $product->id);

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            }
        }

        /**
         * Remove a product from the cart.
         */
        public function removeFromCart(int $userId, Product $product): void
        {
            CartItem::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->delete();
        }
    }
