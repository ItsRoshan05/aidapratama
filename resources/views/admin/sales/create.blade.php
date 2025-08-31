@extends('layouts.app')
@section('title', 'Tambah Penjualan')

@section('content')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-md shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Penjualan</h2>

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sales.store') }}" method="POST">
        @csrf
            <div class="mb-4">
        <label class="block font-medium">No Invoice</label>
        <input type="text" name="invoice_number" class="w-full border p-2 rounded bg-gray-100" value="{{ $invoice_number ?? '' }}" readonly>
        <small class="text-gray-500">Invoice akan digenerate otomatis saat simpan.</small>
    </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-sm text-gray-600">Tanggal Penjualan</label>
                <input type="date" name="sale_date" class="w-full border px-3 py-2 rounded" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
<div>
    <label class="text-sm text-gray-600">Customer (Opsional)</label>
    <select id="customer_id" name="customer_id" class="w-full border px-3 py-2 rounded customer-search">
        <option value="">Pilih Customer</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
</div>

        </div>

    <div>
    <label class="text-sm text-gray-600">Term Pembayaran</label>
    <select name="term" class="w-full border px-3 py-2 rounded" required>
        <option value="0" {{ old('term') == '0' ? 'selected' : '' }}>Cash</option>
        <option value="7" {{ old('term') == '7' ? 'selected' : '' }}>Net7</option>
        <option value="15" {{ old('term') == '15' ? 'selected' : '' }}>Net15</option>
        <option value="30" {{ old('term') == '30' ? 'selected' : '' }}>Net30</option>
    </select>
</div>


        <div class="mt-4">
    <label class="text-sm text-gray-600 block mb-1">Tag Penjualan</label>
    <div id="tag-container" class="flex flex-wrap gap-2 mb-2"></div>

    <input type="text" id="tag-input" class="w-full border px-3 py-2 rounded bg-gray-50" placeholder="Ketik dan tekan Enter..." autocomplete="off">
    <input type="hidden" name="tag" id="tag-hidden" value="{{ old('tag') }}">
</div>


        <h3 class="mt-4 font-semibold text-gray-700">Daftar Produk</h3>
        <div class="flex flex-wrap gap-3 mb-2 justify-end">
            <button type="button" id="add-product-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk
            </button>
        </div>
        <div id="product-wrapper" class="space-y-3"></div>

        <div class="mt-4">
            <label class="text-sm text-gray-600">Catatan (Opsional)</label>
            <textarea name="note" class="w-full border px-3 py-2 rounded" rows="2">{{ old('note') }}</textarea>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.sales.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
let index = 1;
const products = @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'harga_jual' => $p->harga_jual]));

function getProductOptions() {
    return products.map(p => `<option value='${p.id}'>${p.name}</option>`).join('');
}

function getProductRow(idx) {
    return `
        <div class="relative group bg-white shadow-md rounded-lg p-4 grid grid-cols-12 gap-2 items-center border border-gray-200 hover:shadow-lg transition">
            <div class="col-span-3 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                    </svg>
                </span>
                <select name="products[${idx}][product_id]" class="product-select w-full border p-2 rounded focus:ring-2 focus:ring-blue-400" data-idx="${idx}">
                    <option value="">-- Pilih Produk --</option>
                    ${getProductOptions()}
                </select>
            </div>
            <div class="col-span-3 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1m2 0h12m2 0h1M12 3v1m0 2v12m0 2v1"/>
                    </svg>
                </span>
                <input type="decimal" name="products[${idx}][quantity]" min="1" placeholder="Qty" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-3 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm2 4h.01M12 17h.01M17 13h.01"/>
                    </svg>
                </span>
                <input type="number" name="products[${idx}][discount]" min="0" max="100" placeholder="Diskon (%)" class="w-full border p-2 rounded focus:ring-2 focus:ring-pink-400">
            </div>
            <div class="col-span-3 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/>
                    </svg>
                </span>
                <input type="number" name="products[${idx}][price]" min="0" step="0.01" placeholder="Harga" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition remove-product-btn" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
}

function addProductRow() {
    $('#product-wrapper').append(getProductRow(index));
    index++;
    
    $('.product-select').select2({
        placeholder: '-- Pilih Produk --',
        allowClear: true,
        width: '100%',
        height: '30px'
    });
}

$(function() {
    // Tambah 1 row di awal
    addProductRow();

    // Tambah row baru
    $('#add-product-btn').on('click', function(e) {
        e.preventDefault();
        addProductRow();
    });

    // Hapus row
    $('#product-wrapper').on('click', '.remove-product-btn', function() {
        $(this).closest('.grid').remove();
    });

    // Autofill harga jual
    $('#product-wrapper').on('change', '.product-select', function () {
        const idx = $(this).data('idx');
        const selectedId = $(this).val();
        const selectedProduct = products.find(p => p.id == selectedId);
        if (selectedProduct) {
            $(`input[name="products[${idx}][price]"]`).val(selectedProduct.harga_jual);
        } else {
            $(`input[name="products[${idx}][price]"]`).val('');
        }
    });
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tagInput = document.getElementById('tag-input');
        const tagHidden = document.getElementById('tag-hidden');
        const tagContainer = document.getElementById('tag-container');

        tagInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const tagValue = tagInput.value.trim();
                if (tagValue) {
                    addTagBubble(tagValue);
                    tagHidden.value = tagValue;
                    tagInput.value = '';
                    tagInput.classList.add('hidden'); 
                }
            }
        });

        function addTagBubble(tag) {
            tagContainer.innerHTML = ''; // pastikan hanya 1 tag
            const bubble = document.createElement('div');
            bubble.className = 'flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm';
            bubble.innerHTML = `
                <span class="mr-2">${tag}</span>
                <button type="button" class="remove-tag text-blue-500 hover:text-red-600 font-bold">×</button>
            `;
            tagContainer.appendChild(bubble);

            bubble.querySelector('.remove-tag').addEventListener('click', () => {
                bubble.remove();
                tagHidden.value = '';
                tagInput.classList.remove('hidden'); 
            });
        }

        // Jika ada tag dari old input
        const initialTag = tagHidden.value;
        if (initialTag) {
            addTagBubble(initialTag);
            tagInput.classList.add('hidden'); 
        }
    });
</script>
<script>
    // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.customer-search').select2({
        placeholder: 'Pilih Customer',
        allowClear: true,
        width: '100%',
        height: '50px'
    });
    $('.product-select').select2({
        placeholder: '-- Pilih Produk --',
        allowClear: true,
        width: '100%',
        height: '30px'
    });

});

</script>

@endsection
