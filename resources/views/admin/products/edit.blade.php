@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Produk</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

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
                   value="{{ old($field, $product->$field) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
            @error($field)
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endforeach

        <div>
            <label for="unit" class="block text-sm text-gray-600 mb-1">Satuan</label>
            <select name="unit" id="unit" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @foreach(['pcs', 'dus', 'pack', 'box', 'lusin', 'rim', 'kg', 'meter', 'liter', 'roll', 'set', 'buah'] as $unit)
                    <option value="{{ $unit }}" {{ old('unit', $product->unit) == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                @endforeach
            </select>
            @error('unit')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Update</button>
        </div>
    </form>
</div>
@endsection
