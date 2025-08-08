@extends('layouts.app')
@section('title', 'Detail Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Detail Pengeluaran</h2>

    <div class="space-y-3 text-sm">
        <div><span class="text-gray-600">Nama:</span> <strong>{{ $expense->name }}</strong></div>
        <div><span class="text-gray-600">Jumlah:</span> Rp {{ number_format($expense->amount, 0, ',', '.') }}</div>
        <div><span class="text-gray-600">Tanggal:</span> {{ $expense->expense_date->format('d-m-Y') }}</div>
        <div><span class="text-gray-600">Sumber:</span> {{ $expense->sumber }}</div>
        <div><span class="text-gray-600">Penerima:</span> {{ $expense->penerima ?? '-' }}</div>
        <div><span class="text-gray-600">Catatan:</span> {{ $expense->note ?? '-' }}</div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.expenses.index') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded">Kembali</a>
    </div>
</div>
@endsection
