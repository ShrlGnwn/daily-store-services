<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Prefix otomatis /api. Checklist lengkap di PLAN.md.

Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong',
        'time' => now()->toIso8601String(),
    ]);
});

// Produk — bentuk data: FE src/features/catalog/data/products.js
// Filter: ?category= ?popular=1 ?search= ?limit=
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Contoh CRUD (ikutin polanya buat resource lain)
Route::apiResource('categories', CategoryController::class);

// Auth — nanti Sanctum (PLAN.md Fase BF3)
Route::post('/auth/login', function () {
    return 'TODO: {email, password} → {token, user}';
});

Route::get('/me', function () {
    return 'TODO: user login (auth:sanctum)';
});

// Order — FE checkout: src/features/checkout/services/checkoutApi.js
Route::post('/orders', function () {
    return 'TODO: create order (hitung ulang harga di server)';
});

Route::get('/orders', function () {
    return 'TODO: list order user login';
});
