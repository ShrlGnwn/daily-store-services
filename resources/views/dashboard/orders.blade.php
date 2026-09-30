@extends('layouts.dashboard')

@section('title', 'Order')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard-orders.css') }}">
@endpush
@section('content')
    <div id="orders-page"
        data-data-url="{{route('dashboard.orders.data')}}">
        <div class="tollbar">
            <div>
                <h1>List Order</h1>
                <p class="sub" style="margin-bottom:0;">Semua transaksi belanja customer.</p>
            </div>
        </div>
        <div class="card table-card">
            <table id="order-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>Pelanggan</th>
                        <th>Alamat</th>
                        <th>Metode Bayar</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/dashboard-orders.js') }}"></script>
@endpush
