<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CatalogRequest;
    use App\Services\CatalogService;
    use App\Models\Product;
    use Illuminate\View\View;

    class CatalogController extends Controller
    {
        protected CatalogService $catalogService;

        public function __construct(CatalogService $catalogService)
        {
            $this->catalogService = $catalogService;
        }

        /**
         * Display the catalog with filtering and sorting options.
         */
        public function index(CatalogRequest $request): View
        {
            $products = $this->catalogService->getFilteredProducts($request->validated());
            return view('catalog.index', compact('products'));
        }

        /**
         * Search for products by name or ID.
         */
        public function search(CatalogRequest $request): View
        {
            $products = $this->catalogService->searchProducts($request->query('query'));
            return view('catalog.search', compact('products'));
        }

        /**
         * Show a specific product.
         */
        public function show(Product $product): View
        {
            return view('catalog.show', compact('product'));
        }
    }
