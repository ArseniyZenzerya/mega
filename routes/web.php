<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Admin\ProductController;
    use App\Http\Controllers\Admin\OrderController as AdminOrderController;
    use App\Http\Controllers\CatalogController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\OrderController;

// Гостевые маршруты (авторизация и регистрация)
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->name('logout');
    });

// Админ-панель с миддлваром
    Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
        Route::view('/', 'admin.dashboard')->name('admin.dashboard');

        Route::resource('products', ProductController::class)->names('admin.products');
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'edit'])->names('admin.orders');
    });

// Каталог
    Route::controller(CatalogController::class)->group(function () {
        Route::get('/', 'index')->name('catalog.index');
        Route::get('/search', 'search')->name('catalog.search');
        Route::get('/product/{product}', 'show')->name('product.show');
    });

// Корзина
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('cart.index');
        Route::post('add/{product}', 'add')->name('cart.add');
        Route::post('update/{product}', 'update')->name('cart.update');
        Route::post('remove/{product}', 'remove')->name('cart.remove');
    });

// Оформление заказа
    Route::controller(OrderController::class)->group(function () {
        Route::get('/checkout', 'checkout')->name('order.checkout');
        Route::post('/order/place', 'placeOrder')->name('order.place');
        Route::get('/order/success', 'success')->name('order.success');
    });
