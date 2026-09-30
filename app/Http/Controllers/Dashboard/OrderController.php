<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('dashboard.orders');
    }
    public function data(Request $request): JsonResponse
    {
        $draw = (int) $request->input('draw', 1);
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $searchValue = $request->input('search.value', '');
        $query = Order::with('user');
        $recordsTotal = Order::count();
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id', 'like', "%{$searchValue}%")
                ->orWhere('address', 'like', "%{$searchValue}%")
                ->orWhere('payment_method', 'like', "%{$searchValue}%")
                ->orWhere('status', 'like', "%{$searchValue}%")
                ->orWhereHas('user', function ($u) use  ($searchValue) {
                    $u->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('email', 'like', "%{$searchValue}%");
                });
            });
        }
        $recordsFiltered = $query->count();
        $orders = $query->latest()
        ->skip($start)
        ->take($length)
        ->get();
        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->user? $order->user->name: 'Guest',
                'address' => $order->address,
                'payment_method' => strtoupper($order->payment_method),
                'total_price' => 'Rp' . number_format($order->total_price, 0, ',', '.'),
                'status' => ucfirst($order->status),
                'created_at' => $order->created_at ? $order->created_at->format('d M Y H:i') : '-',
            ];
        });
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}