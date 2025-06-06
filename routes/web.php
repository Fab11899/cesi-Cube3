<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('category', function () {
    return Inertia::render('ecommerce/Category');
})->name('category');

Route::get('product', function () {
    // On redirect product vers category
    return redirect()->route('category'); // Redirection vers la page de catégores, car pas de produits à p
});

Route::get('product/{id}', function ($id) {
    return Inertia::render('ecommerce/Product', [
        'productId' => $id, // 👈 tu passes l’ID en props
    ]);
})->name('product-detail');

Route::get('cart', function () {
    return Inertia::render('ecommerce/Cart');
})->name('cart');

// route de debug pour afficher le contenu de la session
Route::get('session', function () {
    return session()->all();
})->name('session');
// route pour vider la session
Route::get('session/clear', function () {
    session()->flush();
    return redirect()->route('home')->with('message', 'Session vidée');
})->name('session.clear');

require 'api.php';
