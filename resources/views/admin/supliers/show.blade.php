@extends('layouts.app')

@section('title', 'Detail Suplier')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Detail Suplier</h2>

    <div class="grid grid-cols-1 gap-4 text-sm text-gray-700">
        <div class="bg-gray-50 rounded-md p-4 shadow-sm">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="font-semibold text-gray-800">Informasi Utama</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                <div><span class="font-medium">Nama</span><div>{{ $suplier->name }}</div></div>
                <div><span class="font-medium">No HP</span><div>{{ $suplier->nohp }}</div></div>
                <div><span class="font-medium">Email</span><div>{{ $suplier->email }}</div></div>
                <div><span class="font-medium">Alamat</span><div>{{ $suplier->alamat }}</div></div>
                <div><span class="font-medium">Jenis Kelamin</span><div>{{ $suplier->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div></div>
                <div><span class="font-medium">Nama PT</span><div>{{ $suplier->nama_pt }}</div></div>
                <div><span class="font-medium">Brand</span><div>{{ $suplier->brand }}</div></div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-md p-4 shadow-sm mt-2">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10v6a2 2 0 002 2h14a2 2 0 002-2v-6M16 10V6a4 4 0 00-8 0v4"/></svg>
                <span class="font-semibold text-blue-800">Informasi Bank / E-Wallet</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                <div><span class="font-medium">Tipe Pembayaran</span><div>{{ $suplier->tipe_bank }}</div></div>
                <div><span class="font-medium">Nama Bank / E-Wallet</span><div>{{ $suplier->nama_bank }}</div></div>
                <div><span class="font-medium">No Rekening</span><div>{{ $suplier->no_rekening }}</div></div>
                <div><span class="font-medium">Atas Nama</span><div>{{ $suplier->atas_nama }}</div></div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.supliers.index') }}"
           class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition">Kembali</a>
    </div>
</div>
@endsection
