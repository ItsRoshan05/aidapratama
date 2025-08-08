@extends('layouts.app')
@section('title', 'Detail Pembelian')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Detail Pembelian</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <div class="text-gray-600">No Invoice</div>
            <div class="font-semibold">{{ $purchase->invoice_number }}</div>
        </div>
        <div>
            <div class="text-gray-600">Tanggal</div>
            <div class="font-semibold">{{ $purchase->purchase_date }}</div>
        </div>
        <div>
            <div class="text-gray-600">Suplier</div>
            <div class="font-semibold">
                @if($purchase->suplier)
                    <a href="{{ route('admin.supliers.show', $purchase->suplier->id) }}" class="text-blue-600 hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $purchase->suplier->name }}
                    </a>
                @else
                    -
                @endif
            </div>
        </div>
        <div>
            <div class="text-gray-600">Total</div>
            <div class="font-semibold text-blue-700">Rp {{ number_format($purchase->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <h3 class="mt-6 font-semibold text-lg text-gray-700 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
        Daftar Item
    </h3>
    <div class="overflow-x-auto mt-2">
        <table class="min-w-full border rounded shadow text-sm">
            <thead class="bg-blue-50">
                <tr>
                    <th class="border px-3 py-2">Produk</th>
                    <th class="border px-3 py-2">Qty</th>
                    <th class="border px-3 py-2">Diskon (%)</th>
                    <th class="border px-3 py-2">Harga</th>
                    <th class="border px-3 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = $purchase->details ?? $purchase->items ?? [];
                @endphp
                @forelse ($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2">{{ $item->product->name ?? '-' }}</td>
                        <td class="border px-3 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="border px-3 py-2 text-center">{{ $item->discount ?? 0 }}%</td>
                        <td class="border px-3 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-gray-400 py-4">Tidak ada item pembelian</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.purchases.index') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition">Kembali</a>
            <a href="{{ route('admin.purchases.print', $purchase->id) }}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
        Cetak Invoice
    </a>
    </div>
    
</div>
@endsection
