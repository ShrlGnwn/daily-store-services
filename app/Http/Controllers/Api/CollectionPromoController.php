<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionPromoController extends Controller
{
    public function getCollectionProducts($key)
    {
        $productIds = DB::table('product_collections')
        ->where('collection_key', $key)
        ->pluck('product_id');
        if ($productIds->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Collection not found or has no products'
            ], 404);
        }
        $products = DB::table('products')
        ->whereIn('id', $productIds)
        ->get();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
    public function getPromoProducts($slug)
    {
        $productIds = DB::table('product_promos')
        ->where('promo_slug', $slug)
        ->pluck('product_id');
        if ($productIds->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo not found or has no products'
            ], 404);
        }
        $products = DB::table('products')
        ->whereIn('id', $productIds)
        ->get();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
}
