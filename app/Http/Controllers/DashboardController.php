<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

/**
 * Halaman DASHBOARD (web) — template minimal.
 *
 * Yang SUDAH jadi di sini cuma kerangka: layout sidebar + halaman kosong.
 * Tugas PKL: isi tiap halaman (mulai dari /dashboard/orders — list order
 * pakai data dari tabel orders, pola query sama seperti CategoryController).
 */
class DashboardController extends Controller
{
    /** Halaman awal dashboard: ringkasan. */
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalCustomers = User::where('access', 'customer')->count();
        $totalRevenue = Order::whereIn('status', ['completed', 'success'])->sum('total_price');
        return view('dashboard.index', compact('totalOrders', 'totalCustomers', 'totalRevenue'));
    }

    /** Contoh halaman kosong: List Order. */
    public function orders(): View
    {
        return view('dashboard.orders');
    }
}
