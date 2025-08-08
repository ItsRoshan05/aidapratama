@extends('layouts.app')

@section('title', 'Tambah Customer')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Customer</h2>

    <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm text-gray-600 mb-1">Nama Customer</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nohp" class="block text-sm text-gray-600 mb-1">No HP</label>
                <input type="text" name="nohp" id="nohp" value="{{ old('nohp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('nohp')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="alamat" class="block text-sm text-gray-600 mb-1">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('alamat')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Simpan</button>
        </div>
    </form>
</div>

<script>
function toggleBank() {
    const tipe = document.querySelector('input[name="tipe_bank"]:checked')?.value;
    const bankList = document.getElementById('bankList');
    const ewalletList = document.getElementById('ewalletList');
    const bankSelect = document.getElementById('nama_bank');
    const ewalletSelect = document.getElementById('nama_ewallet');
    bankList.classList.add('hidden');
    ewalletList.classList.add('hidden');
    bankSelect.disabled = true;
    ewalletSelect.disabled = true;
    if (tipe === 'Bank') {
        bankList.classList.remove('hidden');
        bankSelect.disabled = false;
    } else if (tipe === 'E-Wallet') {
        ewalletList.classList.remove('hidden');
        ewalletSelect.disabled = false;
    }
}

// Sembunyikan bankList & ewalletList saat load awal jika radio belum dipilih
document.addEventListener('DOMContentLoaded', function() {
    const tipe = document.querySelector('input[name="tipe_bank"]:checked');
    const bankList = document.getElementById('bankList');
    const ewalletList = document.getElementById('ewalletList');
    const bankSelect = document.getElementById('nama_bank');
    const ewalletSelect = document.getElementById('nama_ewallet');
    if (!tipe) {
        bankList.classList.add('hidden');
        ewalletList.classList.add('hidden');
        bankSelect.disabled = true;
        ewalletSelect.disabled = true;
    } else {
        toggleBank();
    }
});
</script>
@endsection
