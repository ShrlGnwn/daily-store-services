@extends('layouts.dashboard')

@section('title', 'Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard-index.css') }}">
@endpush
@section('content')
    <h1>Dashboard</h1>
    <p class="sub">Ringkasan toko ASTRO — halaman awal admin untuk statistik dan lainnya.</p>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Order</h3>
            <p class="stat-value">{{number_format($totalOrders)}}</p>
        </div>
        <div class="stat-card">
            <h3>Total Customer</h3>
            <p class="stat-value">{{number_format($totalCustomers)}}</p>
        </div>
        <div class="stat-card">
            <h3>Total Pendapatan</h3>
            <p class="stat-value highlight">Rp{{number_format($totalRevenue, 0, ',','.')}}</p>
        </div>
    </div>
@endsection
