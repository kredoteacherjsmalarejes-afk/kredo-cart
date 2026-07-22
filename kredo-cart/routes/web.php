<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

// Public product routes
Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');


// Logged-in user routes
Route::middleware('auth')->group(function () {

//　Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        // Users
        Route::get('/users', [UsersController::class, 'index'])
            ->name('users.index');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])
            ->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])
            ->name('users.activate');

        Route::get('/products', [ProductsController::class, 'index'])
            ->name('products.index');
        Route::patch('/products/{id}/deactivate', [ProductsController::class, 'deactivate'])
            ->name('products.deactivate');
        Route::patch('/products/{id}/activate', [ProductsController::class, 'activate'])
            ->name('products.activate');
        Route::get('/products/create', [ProductsController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductsController::class, 'store'])
            ->name('products.store');
        Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])
            ->name('products.edit');
        Route::patch('/products/{product}', [ProductsController::class, 'update'])
            ->name('products.update');
        Route::delete('/products/{product}', [ProductsController::class, 'destroy'])
            ->name('products.destroy');

        // Admin product routes
        Route::get('/categories', [CategoriesController::class, 'index'])
            ->name('categories.index');
        Route::get('/categories/create', [CategoriesController::class, 'create'])
            ->name('categories.create');
        Route::post('/categories', [CategoriesController::class, 'store'])
            ->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])
            ->name('categories.edit');
        Route::patch('/categories/{category}', [CategoriesController::class, 'update'])
            ->name('categories.update');
        Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])
            ->name('categories.destroy');

        // Admin category routes
        Route::get('/orders', [OrdersController::class, 'index'])
            ->name('orders.index');
        Route::get('/orders/{order}', [OrdersController::class, 'show'])
            ->name('orders.show');
        Route::patch('/orders/{order}/update-status', [OrdersController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])
            ->name('orders.destroy');

        // Admin customer routes
        Route::get('/customers', [UsersController::class, 'index'])
            ->name('customers.index');
        Route::get('/customers/{customer}', [UsersController::class, 'show'])
            ->name('customers.show');
        Route::patch('/customers/{customer}/update-status', [UsersController::class, 'updateStatus'])
            ->name('customers.updateStatus');
        Route::delete('/customers/{customer}', [UsersController::class, 'destroy'])
            ->name('customers.destroy');
    });

    // Cart
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart', [CartController::class, 'store'])
        ->name('cart.store');

    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::delete('/cart', [CartController::class, 'clear'])
        ->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
