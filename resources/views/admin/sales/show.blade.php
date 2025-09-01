@extends('layouts.app')
@section('title', 'Detail Penjualan')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Detail Penjualan</h2>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <div class="text-gray-600">Invoice</div>
            <div class="font-semibold">{{ $sale->invoice_number }}</div>
        </div>
        <div>
            <div class="text-gray-600">Tanggal</div>
            <div class="font-semibold">
                {{ \Carbon\Carbon::parse($sale->sale_date)->translatedFormat('d F Y') }}
            </div>
        </div>
        <div>
            <div class="text-gray-600">Customer</div>
            <a href="{{ route('admin.customers.show', $sale->customer_id) }}" class="text-blue-600 hover:underline">
                {{ $sale->customer ? $sale->customer->name : 'Tidak ada' }} 
            </a>
        </div>
        <div>
            <div class="text-gray-600">Total</div>
            <div class="font-semibold text-blue-700">Rp {{ number_format($sale->total, 0, ',', '.') }}</div>
        </div>
        <div>
            <div class="text-gray-600">Tag</div>
            <div class="font-semibold text-blue-700">{{ $sale->tag }}</div>
        </div>
        <div>
            <div class="text-gray-600">Jatuh Tempo</div>
            <div class="font-semibold text-blue-700">
                {{ \Carbon\Carbon::parse($sale->deadline_date)->translatedFormat('d F Y') }}
            </div>
        </div>
                <div>
            <div class="text-gray-600">Term</div>
            <div class="font-semibold text-blue-700">{{ $sale->term }} Hari </div>
        </div>
    </div>

    <h3 class="font-semibold text-lg text-gray-700 mb-2">Item Terjual</h3>
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Produk</th>
                <th class="border px-3 py-2">Qty</th>
                <th class="border px-3 py-2">Harga</th>
                <th class="border px-3 py-2">Diskon (%)</th>
                <th class="border px-3 py-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
            <tr class="hover:bg-gray-50">
                <td class="border px-3 py-2">{{ $item->product->name ?? '-' }}</td>
                <td class="border px-3 py-2 text-center">{{ $item->quantity }}</td>
                <td class="border px-3 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="border px-3 py-2 text-center">{{ $item->discount ?? 0 }}%</td>
                <td class="border px-3 py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.sales.index') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded">Kembali</a>
        <a href="{{ url('admin/sales/' . $sale->id . '/print') }}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9v6m6-6v6m6-6v6"/></svg>
            Cetak Invoice
        </a>
    </div>
</div>
@endsection
