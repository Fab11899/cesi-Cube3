<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

Route::get('api/cart/arr', function () {
    return response()->json(['success' => true, 'message' => 'Route atteinte']);
});

Route::post('api/cart/add', [CartController::class, 'addToCart']);
Route::get('api/cart', [CartController::class, 'getCart']);
Route::delete('api/cart/remove/{id}', [CartController::class, 'removeFromCart']);


Route::get('api/products', [ProductController::class, 'index']);
Route::get('api/product/{id}', [ProductController::class, 'show']);

