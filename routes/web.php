<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;

// Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.store');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('products.index');
    })->name('dashboard');
});

Route::get('/products', [ProductsController::class, 'index'])->name('Products.index');

Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show');

Route::get('/create', [ProductsController::class, 'create'])->name('products.create');

Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');

Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update');

Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

Route::post('/products', [ProductsController::class, 'store'])->name('products.store');

Route::get('/products/cart', [ProductsController::class, 'cart'])->name('Products.cart');

Route::post('/products/{product}/add-to-cart', [ProductsController::class, 'addToCart'])->name('products.addToCart');

// Route::resource('products', ProductsController::class);

Route::get('api/cart', [CartController::class, 'index'])->name('cart.index');

Route::put('api/cart/{id}', [CartController::class, 'update'])->name('cart.update');

Route::delete('api/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

require __DIR__.'/auth.php';
