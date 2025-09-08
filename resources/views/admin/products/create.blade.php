@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Produk</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
        @csrf

        @foreach ([
            'name' => 'Nama Produk',
            'sku' => 'SKU',
            'category' => 'Kategori',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'stock' => 'Stok',
        ] as $field => $label)
        <div>
            <label for="{{ $field }}" class="block text-sm text-gray-600 mb-1">{{ $label }}</label>
            <input type="text" name="{{ $field }}" id="{{ $field }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500"
                   value="{{ old($field) }}">
            @error($field)
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endforeach
        <div>
            <label for="unit" class="block text-sm text-gray-600 mb-1">Satuan</label>
            <select name="unit" id="unit" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                <option value="">Pilih Satuan</option>
                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                <option value="dus" {{ old('unit') == 'dus' ? 'selected' : '' }}>dus</option>
                <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>liter</option>
                <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>pack</option>
                <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>box</option>
                <option value="lusin" {{ old('unit') == 'lusin' ? 'selected' : '' }}>lusin</option>
                <option value="bungkus" {{ old('unit') == 'bungkus' ? 'selected' : '' }}>bungkus</option>
                <option value="ball" {{ old('unit') == 'ball' ? 'selected' : '' }}>ball</option>
                <option value="ikat" {{ old('unit') == 'ikat' ? 'selected' : '' }}>ikat</option>
                <option value="ons" {{ old('unit') == 'ons' ? 'selected' : '' }}>ons</option>
                <option value="gros" {{ old('unit') == 'gros' ? 'selected' : '' }}>gros</option>
                <option value="bks" {{ old('unit') == 'bks' ? 'selected' : '' }}>bks</option>
                <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>roll</option>
            </select>
            @error('unit')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
