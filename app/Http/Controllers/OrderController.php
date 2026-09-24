<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_fee' => 'nullable|numeric|min:0',
        ]);
        $shippingFee = $validated['shipping_fee'] ?? 0;
        $itemsData = [];
        $subtotal = 0;

        try {
            return DB::transaction(function () use ($request, $validated, $shippingFee, &$subtotal, &$itemsData){
                foreach ($validated['items'] as $item) {
                    $product = Product::where('id', $item['id'])->lockForUpdate()->first();
                    if (!$product) {
                        return response()->json([
                            'message' => 'Produk tidak ditemukan.'
                        ], 440);
                    }
                    if ($product->stock < $item ['qty']) {
                        return response()->json([
                            'message' => "Stok produk '{$product->name}' tidak mencukupi (Tersisa: {$product->stock})"
                        ], 400);
                    }
                    $itemPrice = $product->price;
                    $itemTotal = $itemPrice * $item['qty'];
                    $subtotal += $itemTotal;
                    $product->decrement('stock', $item['qty']);
                    $itemsData[] = [
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $itemPrice,
                    ];
                }
                $totalPrice = $subtotal + $shippingFee;
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'address' => $validated['address'],
                    'payment_method' => $validated['payment_method'],
                    'subtotal' => $subtotal,
                    'shipping_fee' => $shippingFee,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);
                foreach ($itemsData as $data) {
                    $order->orderItems()->create($data);
                }
                return response()->json([
                    'message' => 'Order berhasil dibuat.',
                    'data' => $order->load('orderItems')
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat order: ' . $e->getMessage()
            ], 500);
        }
    }
}
