@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Ganti Password</h1>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label for="current_password" class="block text-sm font-medium">Password Lama</label>
            <input type="password" name="current_password" id="current_password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            @error('current_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password" class="block text-sm font-medium">Password Baru</label>
            <input type="password" name="new_password" id="new_password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            @error('new_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password_confirmation" class="block text-sm font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Simpan Password Baru
            </button>
        </div>
    </form>
</div>
@endsection
