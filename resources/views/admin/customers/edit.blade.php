@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Customer</h2>

    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm text-gray-600 mb-1">Nama Customer</label>
                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nohp" class="block text-sm text-gray-600 mb-1">No HP</label>
                <input type="text" name="nohp" id="nohp" value="{{ old('nohp', $customer->nohp) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('nohp')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('email')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="alamat" class="block text-sm text-gray-600 mb-1">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $customer->alamat) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('alamat')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label><input type="radio" name="jenis_kelamin" value="L" class="mr-1" {{ old('jenis_kelamin', $customer->jenis_kelamin)=='L'?'checked':'' }}> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="P" class="mr-1" {{ old('jenis_kelamin', $customer->jenis_kelamin)=='P'?'checked':'' }}> Perempuan</label>
                </div>
                @error('jenis_kelamin')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tipe Pembayaran</label>
                <div class="flex items-center space-x-4">
                    <label><input type="radio" name="tipe_bank" value="Bank" class="mr-1" onchange="toggleBank()" {{ old('tipe_bank', $customer->tipe_bank)=='Bank'?'checked':'' }}> Bank</label>
                    <label><input type="radio" name="tipe_bank" value="E-Wallet" class="mr-1" onchange="toggleBank()" {{ old('tipe_bank', $customer->tipe_bank)=='E-Wallet'?'checked':'' }}> E-Wallet</label>
                </div>
                @error('tipe_bank')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2" id="bankList" style="display:none;">
                <label for="nama_bank" class="block text-sm text-gray-600 mb-1">Nama Bank</label>
                <select name="nama_bank" id="nama_bank" class="w-full px-4 py-2 border border-gray-300 rounded-md" disabled>
                    <option value="">Pilih Bank</option>
                    <option value="BCA" {{ old('nama_bank', $customer->nama_bank)=='BCA'?'selected':'' }}>BCA</option>
                    <option value="Mandiri" {{ old('nama_bank', $customer->nama_bank)=='Mandiri'?'selected':'' }}>Mandiri</option>
                    <option value="BRI" {{ old('nama_bank', $customer->nama_bank)=='BRI'?'selected':'' }}>BRI</option>
                    <option value="BNI" {{ old('nama_bank', $customer->nama_bank)=='BNI'?'selected':'' }}>BNI</option>
                </select>
                @error('nama_bank')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2" id="ewalletList" style="display:none;">
                <label for="nama_ewallet" class="block text-sm text-gray-600 mb-1">Nama E-Wallet</label>
                <select name="nama_bank" id="nama_ewallet" class="w-full px-4 py-2 border border-gray-300 rounded-md" disabled>
                    <option value="">Pilih E-Wallet</option>
                    <option value="Gopay" {{ old('nama_bank', $customer->nama_bank)=='Gopay'?'selected':'' }}>Gopay</option>
                    <option value="Dana" {{ old('nama_bank', $customer->nama_bank)=='Dana'?'selected':'' }}>Dana</option>
                    <option value="OVO" {{ old('nama_bank', $customer->nama_bank)=='OVO'?'selected':'' }}>OVO</option>
                    <option value="ShopeePay" {{ old('nama_bank', $customer->nama_bank)=='ShopeePay'?'selected':'' }}>ShopeePay</option>
                </select>
                @error('nama_bank')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="no_rekening" class="block text-sm text-gray-600 mb-1">No Rekening</label>
                <input type="text" name="no_rekening" id="no_rekening" value="{{ old('no_rekening', $customer->no_rekening) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('no_rekening')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="atas_nama" class="block text-sm text-gray-600 mb-1">Atas Nama</label>
                <input type="text" name="atas_nama" id="atas_nama" value="{{ old('atas_nama', $customer->atas_nama) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                @error('atas_nama')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Update</button>
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
    bankList.style.display = 'none';
    ewalletList.style.display = 'none';
    bankSelect.disabled = true;
    ewalletSelect.disabled = true;
    if (tipe === 'Bank') {
        bankList.style.display = '';
        bankSelect.disabled = false;
    } else if (tipe === 'E-Wallet') {
        ewalletList.style.display = '';
        ewalletSelect.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const tipe = document.querySelector('input[name="tipe_bank"]:checked');
    if (!tipe) {
        document.getElementById('bankList').style.display = 'none';
        document.getElementById('ewalletList').style.display = 'none';
        document.getElementById('nama_bank').disabled = true;
        document.getElementById('nama_ewallet').disabled = true;
    } else {
        toggleBank();
    }
});
</script>
@endsection
