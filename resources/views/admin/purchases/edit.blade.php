@extends('layouts.app')
@section('title', 'Edit Pembelian')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Pembelian</h2>

<form method="POST" action="{{ route('admin.purchases.update', $purchase->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium">Suplier</label>
        <select name="suplier_id" class="w-full border p-2 rounded">
            @foreach ($supliers as $s)
                <option value="{{ $s->id }}" @if($s->id == $purchase->suplier_id) selected @endif>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">No Invoice</label>
        <input type="text" name="invoice_number" class="w-full border p-2 rounded bg-gray-100" value="{{ $purchase->invoice_number }}" readonly>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Tanggal Pembelian</label>
        <input type="date" name="purchase_date" class="w-full border p-2 rounded" value="{{ $purchase->purchase_date }}">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border p-2 rounded" rows="3">{{ $purchase->deskripsi }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Produk</label>
        <div id="product-wrapper" class="space-y-3">
            @php
                $items = $purchase->details ?? $purchase->items ?? [];
            @endphp
            @foreach ($items as $idx => $item)
            <div class="relative group bg-white shadow-md rounded-lg p-4 grid grid-cols-12 gap-2 items-center border border-gray-200 hover:shadow-lg transition">
                <div class="col-span-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                    </span>
                    <select name="products[{{ $idx }}][product_id]" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" @if($p->id == $item->product_id) selected @endif>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1m2 0h12m2 0h1M12 3v1m0 2v12m0 2v1"/></svg>
                    </span>
                    <input type="number" name="products[{{ $idx }}][quantity]" min="1" value="{{ $item->quantity }}" placeholder="Qty" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm2 4h.01M12 17h.01M17 13h.01"/></svg>
                    </span>
                    <input type="number" name="products[{{ $idx }}][discount]" min="0" max="100" value="{{ $item->discount }}" placeholder="Diskon (%)" class="w-full border p-2 rounded focus:ring-2 focus:ring-pink-400">
                </div>
                <div class="col-span-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/></svg>
                    </span>
                    <input type="number" name="products[{{ $idx }}][price]" min="0" step="0.01" value="{{ $item->price }}" placeholder="Harga" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                </div>
            </div>
            @endforeach
        </div>
        <!-- Tombol tambah produk bisa ditambahkan jika ingin fitur tambah row baru -->
    </div>

    <div class="flex flex-wrap gap-3 mt-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Simpan Perubahan
        </button>
        <a href="{{ route('admin.purchases.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded shadow transition flex items-center gap-2">Kembali</a>
    </div>
</form>
@endsection
