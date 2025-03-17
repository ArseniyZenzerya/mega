<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CartUpdateRequest;
    use App\Models\Product;
    use App\Services\CartService;
    use Illuminate\View\View;
    use Illuminate\Http\RedirectResponse;

    class CartController extends Controller
    {
        private CartService $cartService;

        public function __construct(CartService $cartService)
        {
            $this->cartService = $cartService;
        }

        /**
         * Display the cart page.
         */
        public function index(): View
        {
            $cartItems = $this->cartService->getUserCart(auth()->id());

            foreach ($cartItems as $item) {
                if ($item->quantity > $item->available_stock) {
                    session()->flash('error', "Товар '{$item->product->name}' доступен в количестве {$item->available_stock} шт.");
                    $item->quantity = $item->available_stock;
                }
            }

            return view('cart.index', compact('cartItems'));
        }

        /**
         * Add a product to the cart.
         */
        public function add(Product $product): RedirectResponse
        {
            $this->cartService->addToCart(auth()->id(), $product);
            return redirect()->route('cart.index');
        }

        /**
         * Update the quantity of a product in the cart.
         */
        public function update(CartUpdateRequest $request, Product $product): RedirectResponse
        {
            $this->cartService->updateCart(auth()->id(), $product, $request->validated()['quantity']);
            return redirect()->route('cart.index');
        }

        /**
         * Remove a product from the cart.
         */
        public function remove(Product $product): RedirectResponse
        {
            $this->cartService->removeFromCart(auth()->id(), $product);
            return redirect()->route('cart.index');
        }
    }
