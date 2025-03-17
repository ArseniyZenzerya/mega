<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\PlaceOrderRequest;
    use App\Services\OrderService;
    use Illuminate\View\View;
    use Illuminate\Http\RedirectResponse;

    class OrderController extends Controller
    {
        private OrderService $orderService;

        public function __construct(OrderService $orderService)
        {
            $this->orderService = $orderService;
        }

        /**
         * Display the checkout page.
         */
        public function checkout(): View
        {
            return view('order.checkout');
        }

        /**
         * Handle the order placement.
         */
        public function placeOrder(PlaceOrderRequest $request): RedirectResponse
        {
            $this->orderService->placeOrder(auth()->id(), $request->validated());
            return redirect()->route('order.success');
        }

        /**
         * Show success page after order placement.
         */
        public function success(): View
        {
            return view('order.success');
        }
    }
