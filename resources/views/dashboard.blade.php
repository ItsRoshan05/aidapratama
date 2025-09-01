@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Produk</p>
            <h3 class="text-2xl font-bold text-blue-600">{{ number_format($totalProducts) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Penjualan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
        </div>
        @if(Auth::user()->role === 'owner')
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Laba</p>
            <h3 class="text-2xl font-bold text-pink-600">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
        </div>
        @endif
    </div>

    {{-- Shortcut Tambah Data --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if(Auth::user()->role === 'owner')
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah User</span>
            <p class="text-sm">Kelola akun pengguna sistem</p>
        </a>
    @endif
        <a href="{{ route('admin.customers.create') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah Customer</span>
            <p class="text-sm">Tambahkan data pelanggan baru</p>
        </a>
        @if(Auth::user()->role === 'owner')
        <a href="{{ route('admin.supliers.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah Supplier</span>
            <p class="text-sm">Tambahkan data pemasok produk</p>
        </a>
        @endif
        <a href="{{ route('admin.sales.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah Penjualan</span>
            <p class="text-sm">Catat transaksi penjualan</p>
        </a>
        @if(Auth::user()->role === 'owner')
        <a href="{{ route('admin.purchases.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah Pembelian</span>
            <p class="text-sm">Catat transaksi pembelian</p>
        </a>
        <a href="{{ route('admin.expenses.create') }}" class="bg-red-500 hover:bg-red-600 text-white p-6 rounded-2xl shadow flex flex-col items-center transition duration-200">
            <span class="text-xl font-bold mb-2">+ Tambah Biaya</span>
            <p class="text-sm">Catat pengeluaran operasional</p>
        </a>
        @endif
    </div>
@endsection
