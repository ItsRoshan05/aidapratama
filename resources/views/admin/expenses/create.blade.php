@extends('layouts.app')
@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Pengeluaran</h2>

    <form action="{{ route('admin.expenses.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm text-gray-600 mb-1">Nama Biaya</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="amount" class="block text-sm text-gray-600 mb-1">Jumlah (Rp)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('amount')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="expense_date" class="block text-sm text-gray-600 mb-1">Tanggal</label>
                <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('expense_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label for="penerima" class="block text-sm text-gray-600 mb-1">Penerima</label>
                <input type="text" name="penerima" id="penerima" value="{{ old('penerima') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('penerima')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label for="note" class="block text-sm text-gray-600 mb-1">Catatan</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">{{ old('note') }}</textarea>
                @error('note')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Simpan</button>
            <a href="{{ route('admin.expenses.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
