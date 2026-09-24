<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollectionPromoController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
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

Route::get('/collections/{key}/products', [CollectionPromoController::class, 'getCollectionProducts']);
Route::get('/promos/{slug}/products', [CollectionPromoController::class, 'getPromoProducts']);

// Contoh CRUD (ikutin polanya buat resource lain)
Route::apiResource('categories', CategoryController::class);

// Auth — nanti Sanctum (PLAN.md Fase BF3)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
    

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/orders', [OrderController::class, 'store']);
});

// Order — FE checkout: src/features/checkout/services/checkoutApi.js


Route::get('/orders', function () {
    return 'TODO: list order user login';
});
