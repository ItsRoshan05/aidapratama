@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Detail Customer</h2>


    <div class="grid grid-cols-1 gap-4 text-sm text-gray-700">
        <div class="bg-gray-50 rounded-md p-4 shadow-sm">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="font-semibold text-gray-800">Informasi Utama</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                <div><span class="font-medium">Nama</span><div>{{ $customer->name }}</div></div>
                <div><span class="font-medium">No HP</span><div>{{ $customer->nohp }}</div></div>
                <div><span class="font-medium">Alamat</span><div>{{ $customer->alamat }}</div></div>
                <div><span class="font-medium">Jenis Kelamin</span><div>{{ $customer->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div></div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.customers.index') }}"
           class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition">Kembali</a>
    </div>
</div>
@endsection