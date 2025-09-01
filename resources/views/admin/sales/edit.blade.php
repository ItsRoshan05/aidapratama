@extends('layouts.app')
@section('title', 'Edit Penjualan')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Penjualan</h2>

<form method="POST" action="{{ route('admin.sales.update', $sale->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium">Customer</label>
        <select name="customer_id" class="w-full border p-2 rounded">
            <option value="">Pilih Customer</option>
            @foreach ($customers as $c)
                <option value="{{ $c->id }}" @if($c->id == $sale->customer_id) selected @endif>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
            <div class="mt-4">
    <label class="text-sm text-gray-600 block mb-1">Tag Penjualan</label>
    <div id="tag-container" class="flex flex-wrap gap-2 mb-2"></div>

    <input type="text" id="tag-input" class="w-full border px-3 py-2 rounded bg-gray-50" placeholder="Ketik dan tekan Enter..." autocomplete="off">
    <input type="hidden" name="tag" id="tag-hidden" value="{{ $sale->tag }}">
</div>

    <div class="mb-4">
        <label class="block font-medium">No Invoice</label>
        <input type="text" name="invoice_number" class="w-full border p-2 rounded bg-gray-100" value="{{ $sale->invoice_number }}" readonly>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Tanggal Penjualan</label>
        <input type="date" name="sale_date" class="w-full border p-2 rounded" value="{{ $sale->sale_date }}">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Catatan</label>
        <textarea name="note" class="w-full border p-2 rounded" rows="3">{{ $sale->note }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Term Pembayaran</label>
        <select name="term" class="w-full border p-2 rounded" required>
            <option value="0" {{ $sale->term == '0' ? 'selected' : '' }}>Cash</option>
            <option value="7" {{ $sale->term == '7' ? 'selected' : '' }}>Net7</option>
            <option value="15" {{ $sale->term == '15' ? 'selected' : '' }}>Net15</option>
            <option value="30" {{ $sale->term == '30' ? 'selected' : '' }}>Net30</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Produk</label>
        <div class="flex flex-wrap gap-3 mb-2 justify-end">
            <button type="button" id="add-product-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk
            </button>
        </div>
        <div id="product-wrapper" class="space-y-3">
            @foreach ($sale->items as $idx => $item)
            <div class="relative group bg-white shadow-md rounded-lg p-4 grid grid-cols-12 gap-2 items-center border border-gray-200 hover:shadow-lg transition">
                <div class="col-span-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                    </span>
                    <select name="products[{{ $idx }}][product_id]" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" @if($p->id == $item->product_id) selected @endif>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1m2 0h12m2 0h1M12 3v1m0 2v12m0 2v1"/></svg>
                    </span>
                    <input type="decimal" name="products[{{ $idx }}][quantity]" min="1" value="{{ $item->quantity }}" placeholder="Qty" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="col-span-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm2 4h.01M12 17h.01M17 13h.01"/></svg>
                    </span>
                    <input type="number" name="products[{{ $idx }}][discount]" min="0" max="100" value="{{ $item->discount }}" placeholder="Diskon (%)" class="w-full border p-2 rounded focus:ring-2 focus:ring-pink-400">
                </div>
                <div class="col-span-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/></svg>
                    </span>
                    <input type="number" name="products[{{ $idx }}][price]" min="0" step="0.01" value="{{ $item->price }}" placeholder="Harga" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mt-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Simpan Perubahan
        </button>
        <a href="{{ route('admin.sales.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded shadow transition flex items-center gap-2">Kembali</a>
    </div>
</form>
@endsection

@section('scripts')
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
                    tagInput.classList.add('hidden'); // 🔒 hide input setelah 1 tag masuk
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
                tagInput.classList.remove('hidden'); // 🔓 tampilkan kembali input jika bubble dihapus
            });
        }

        // Jika ada tag dari old input
        const initialTag = tagHidden.value;
        if (initialTag) {
            addTagBubble(initialTag);
            tagInput.classList.add('hidden'); // hide input jika sudah ada tag saat page load
        }

        // Produk dinamis
        let index = {{ count($sale->items) }};
        const products = @json($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name]));

        function getProductOptions() {
            return products.map(p => `<option value='${p.id}'>${p.name}</option>`).join('');
        }

        function getProductRow(idx) {
            return `
                <div class="relative group bg-white shadow-md rounded-lg p-4 grid grid-cols-12 gap-2 items-center border border-gray-200 hover:shadow-lg transition">
                    <div class="col-span-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                        </span>
                        <select name="products[${idx}][product_id]" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                            ${getProductOptions()}
                        </select>
                    </div>
                    <div class="col-span-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h1m2 0h12m2 0h1M12 3v1m0 2v12m0 2v1"/></svg>
                        </span>
                        <input type="number" name="products[${idx}][quantity]" min="1" placeholder="Qty" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="col-span-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-600 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm2 4h.01M12 17h.01M17 13h.01"/></svg>
                        </span>
                        <input type="number" name="products[${idx}][discount]" min="0" max="100" placeholder="Diskon (%)" class="w-full border p-2 rounded focus:ring-2 focus:ring-pink-400">
                    </div>
                    <div class="col-span-3 flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4"/></svg>
                        </span>
                        <input type="number" name="products[${idx}][price]" min="0" step="0.01" placeholder="Harga" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
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

        $('#add-product-btn').on('click', function(e) {
            e.preventDefault();
            addProductRow();
        });
        // Hapus row produk
        $('#product-wrapper').on('click', '.remove-product-btn', function() {
            $(this).closest('.grid').remove();
        });
    });
</script>
@endsection