@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Detail Produk</h2>

<div class="grid grid-cols-1 gap-4 text-sm text-gray-700">
    @foreach ([
        'Nama Produk' => $product->name,
        'SKU' => $product->sku,
        'Kategori' => $product->category,
        // Harga Beli hanya untuk owner
        'Harga Beli' => auth()->user()->role === 'owner' ? 'Rp ' . number_format($product->harga_beli, 0, ',', '.') : null,
        'Harga Jual' => 'Rp ' . number_format($product->harga_jual, 0, ',', '.'),
        'Stok' => $product->stock,
        'Satuan' => $product->unit,
    ] as $label => $value)
        @if($value !== null) 
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium">{{ $label }}</span>
                <span>{{ $value }}</span>
            </div>
        @endif
    @endforeach
</div>


    <div class="mt-6">
        <a href="{{ route('admin.products.index') }}"
           class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition">Kembali</a>
    </div>
</div>
@endsection
