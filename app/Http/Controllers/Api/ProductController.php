<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        if ($request->has('popular')) {
            $isPopular = filter_var($request->popular, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_popular', $isPopular);
        }
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->has('limit') && is_numeric($request->limit)) {
            $products = $query->limit((int) $request->limit)->get();
        } else {
            $products = $query->get();
        }
        return ProductResource::collection($products);
    }
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return new ProductResource($product);
    }
}
