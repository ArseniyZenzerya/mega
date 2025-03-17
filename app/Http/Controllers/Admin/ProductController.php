<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\ProductRequest;
    use App\Models\Product;
    use App\Services\ProductService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\View\View;

    class ProductController extends Controller
    {
        private ProductService $productService;

        public function __construct(ProductService $productService)
        {
            $this->productService = $productService;
        }

        /**
         * Display a listing of the products.
         */
        public function index(): View
        {
            $products = $this->productService->getAllProducts();
            return view('admin.products.index', compact('products'));
        }

        /**
         * Show the form for creating a new product.
         */
        public function create(): View
        {
            return view('admin.products.create');
        }

        /**
         * Store a newly created product in storage.
         */
        public function store(ProductRequest $request): RedirectResponse
        {
            $this->productService->createProduct($request->validated());
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        }

        /**
         * Show the form for editing the specified product.
         */
        public function edit(Product $product): View
        {
            return view('admin.products.edit', compact('product'));
        }

        /**
         * Update the specified product in storage.
         */
        public function update(ProductRequest $request, Product $product): RedirectResponse
        {
            $this->productService->updateProduct($product, $request->validated());
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        }

        /**
         * Remove the specified product from storage.
         */
        public function destroy(Product $product): RedirectResponse
        {
            $this->productService->deleteProduct($product);
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        }
    }
