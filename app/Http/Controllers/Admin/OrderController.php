<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\OrderStatusRequest;
    use App\Http\Requests\PlaceOrderRequest;
    use App\Models\Order;
    use App\Services\OrderService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\View\View;

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

        /**
         * Display a list of all orders.
         */
        public function index(): View
        {
            $orders = Order::with('user')->get();
            return view('admin.orders.index', compact('orders'));
        }

        /**
         * Display a specific order.
         */
        public function show(Order $order): View
        {
            return view('admin.orders.show', compact('order'));
        }

        /**
         * Update the status of an order.
         */
        public function update(Order $order, OrderStatusRequest $request): RedirectResponse
        {
            $order->update(['status' => $request->validated()['status']]);
            return redirect()->route('admin.orders.index');
        }
    }
