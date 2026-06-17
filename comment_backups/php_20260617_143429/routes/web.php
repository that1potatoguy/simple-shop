<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    return redirect()->route('shop.index');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::post('/shop/add', [ShopController::class, 'addToCart'])->name('shop.add');
Route::get('/shop/cart', [ShopController::class, 'cart'])->name('shop.cart');
Route::get('/shop/checkout', [ShopController::class, 'cart'])->name('shop.checkout');
Route::post('/shop/checkout', [ShopController::class, 'checkout'])->name('shop.checkout.post');
Route::get('/shop/thankyou/{order}', [ShopController::class, 'thankyou'])->name('shop.thankyou');
