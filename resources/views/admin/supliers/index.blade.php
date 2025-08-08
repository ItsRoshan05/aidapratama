@extends('layouts.app')

@section('title', 'Data Suplier')

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
        <h2 class="text-xl font-semibold text-gray-800">Data Suplier</h2>
        <a href="{{ route('admin.supliers.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-md shadow hover:bg-blue-700 transition">+ Tambah Data</a>
    </div>
    <div class="overflow-x-auto">
        <table id="customerTable" class="min-w-full text-sm text-gray-700 border border-gray-200 shadow-sm rounded-md overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Nomor Handphone</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                    <th class="px-4 py-3 text-left">Nama Perusahaan</th>
                    <th class="px-4 py-3 text-left">Brand</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($supliers as $i => $suplier)
                <tr>
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">{{ $suplier->name }}</td>
                    <td class="px-4 py-3">{{ $suplier->nohp }}</td>
                    <td class="px-4 py-3">{{ $suplier->email }}</td>
                    <td class="px-4 py-3">{{ $suplier->alamat }}</td>
                    <td class="px-4 py-3">{{ $suplier->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="px-4 py-3">{{ $suplier->nama_pt }}</td>
                    <td class="px-4 py-3">{{ $suplier->brand }}</td>

                    <td class="px-4 py-3">
                        <div class="flex justify-center space-x-3 text-gray-500">
                            <a href="{{ route('admin.supliers.show', $suplier['id']) }}" title="Lihat"><i data-lucide="eye" class="w-4 h-4 hover:text-blue-500 transition"></i></a>
                            <a href="{{ route('admin.supliers.edit', $suplier['id']) }}" title="Edit"><i data-lucide="edit-3" class="w-4 h-4 hover:text-green-500 transition"></i></a>
                            <form action="{{ route('admin.supliers.destroy', $suplier['id']) }}" method="POST" class="inline">
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
        $('#customerTable').DataTable({
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
