@extends('layouts.app')

@section('title', 'Data Pengeluaran')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('content')
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-700 border border-green-200 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="p-6 bg-white rounded-md shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Data Pengeluaran</h2>
        <a href="{{ route('admin.expenses.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-md shadow hover:bg-blue-700 transition">+ Tambah Data</a>
    </div>

    <div class="overflow-x-auto">
        <table id="expensesTable" class="min-w-full text-sm text-gray-700 border border-gray-200 shadow-sm rounded-md overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Biaya</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Penerima</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($expenses as $i => $expense)
                <tr>
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">{{ $expense->name }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $expense->expense_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $expense->penerima ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center space-x-3 text-gray-500">
                            <a href="{{ route('admin.expenses.show', $expense->id) }}" title="Lihat"><i data-lucide="eye" class="w-4 h-4 hover:text-blue-500 transition"></i></a>
                            <a href="{{ route('admin.expenses.edit', $expense->id) }}" title="Edit"><i data-lucide="edit-3" class="w-4 h-4 hover:text-green-500 transition"></i></a>
                            <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i data-lucide="trash-2" class="w-4 h-4 hover:text-red-500 transition"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#expensesTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal", last: "Akhir", next: "›", previous: "‹"
                },
                zeroRecords: "Tidak ada data ditemukan"
            }
        });

        lucide.createIcons();
    });
</script>
@endsection
