@extends('layouts.app')
@section('title', 'Tambah Pembelian')

@section('content')
<h2 class="text-xl font-bold mb-4">Form Tambah Pembelian</h2>

<form method="POST" action="{{ route('admin.purchases.store') }}">
    @csrf

    <div class="mb-4">
        <label class="block font-medium">Suplier</label>
        <select name="suplier_id" class="w-full border p-2 rounded">
            @foreach ($supliers as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">No Invoice</label>
        <input type="text" name="invoice_number" class="w-full border p-2 rounded bg-gray-100">
        <!-- <small class="text-gray-500">Invoice akan digenerate otomatis saat simpan.</small> -->
    </div>

    <div class="mb-4">
        <label class="block font-medium">Tanggal Pembelian</label>
        <input type="date" name="purchase_date" class="w-full border p-2 rounded" value = "{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
    </div>

    <div class="mb-4">
    <label class="block font-medium">Deskripsi</label>
    <textarea name="deskripsi" class="w-full border p-2 rounded" rows="3"></textarea>
</div>


    <div class="mb-4">
        <label class="block font-medium">Produk</label>
        <div id="product-wrapper" class="space-y-3"></div>
        <div class="flex flex-wrap gap-3 mt-2">
            <button type="button" id="add-product-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>


</form>
@endsection

@section('scripts')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
let index = 1;
let products = @json($products);

function getProductOptions() {
    return `
        <option value="">Pilih Produk</option>
        ${products.map(p => `<option value='${p.id}'>${p.name}</option>`).join('')}
    `;
}

function getProductRow(idx) {
    return `
        <div class="relative group bg-white shadow-md rounded-lg p-4 grid grid-cols-12 gap-2 items-center border border-gray-200 hover:shadow-lg transition">
            <div class="col-span-4 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                </span>
                <select name="products[${idx}][product_id]" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                    ${getProductOptions()}
                </select>
            </div>

            <div class="col-span-2 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1m2 0h12m2 0h1M12 3v1m0 2v12m0 2v1"/></svg>
                </span>
                <input type="number" name="products[${idx}][quantity]" min="1" placeholder="Qty" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="col-span-2 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm2 4h.01M12 17h.01M17 13h.01"/></svg>
                </span>
                <input type="number" name="products[${idx}][discount]" min="0" max="100" placeholder="Diskon (%)" class="w-full border p-2 rounded focus:ring-2 focus:ring-pink-400">
            </div>

            <div class="col-span-4 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/></svg>
                </span>
                <div class="flex w-full border rounded overflow-hidden focus-within:ring-2 focus-within:ring-blue-400">
                    <span class="px-2 bg-gray-100 text-gray-600 flex items-center">Rp</span>
                    <input type="number" name="products[${idx}][price]" min="0" step="0.01" placeholder="Harga"
                        class="w-full p-2 border-0 focus:ring-0 focus:outline-none price-input">
                </div>
            </div>

            <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition remove-product-btn" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    `;
}

function addProductRow() {
    $('#product-wrapper').append(getProductRow(index));
    index++;
}

$(function() {
    addProductRow();

    $('#add-product-btn').on('click', function(e) {
        e.preventDefault();
        addProductRow();
    });

    $('#product-wrapper').on('click', '.remove-product-btn', function() {
        $(this).closest('.grid').remove();
    });

    // Autofill harga_beli saat produk dipilih
    $('#product-wrapper').on('change', 'select[name^="products"][name$="[product_id]"]', function() {
        const selectedId = $(this).val();
        const product = products.find(p => p.id == selectedId);
        if (product) {
            const wrapper = $(this).closest('.grid');
            wrapper.find('.price-input').val(product.harga_beli);
        }
    });
});
</script>
@endsection
