@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Laporan Penjualan</h1>

    <form method="GET" class="mb-6 grid md:grid-cols-3 gap-4 items-end">
        <div>
            <label for="start_date" class="block text-sm font-medium">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date', $start->toDateString()) }}"
                class="border-gray-300 rounded-md shadow-sm w-full">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium">Tanggal Selesai</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date', $end->toDateString()) }}"
                class="border-gray-300 rounded-md shadow-sm w-full">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Filter</button>
            <button type="button" id="toggleFilter" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Filter Lanjutan
            </button>
        </div>
    </form>

    <!-- Sidebar Filter Lanjutan (kanan) -->
    <div id="filterSidebarOverlay" class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden"></div>
    <div id="filterSidebar" class="fixed top-0 right-0 left-auto h-full w-80 bg-white shadow-lg z-50 p-6 transition-transform duration-300 translate-x-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Filter Lanjutan</h3>
            <button type="button" id="closeFilterSidebar" class="text-gray-500 hover:text-red-600 text-xl font-bold">×</button>
        </div>
        <form method="GET" class="space-y-4">
            <div>
                <label for="sidebar_start_date" class="block text-sm font-medium">Tanggal Mulai</label>
                <input type="date" id="sidebar_start_date" name="start_date" value="{{ request('start_date', $start->toDateString()) }}" class="border-gray-300 rounded-md shadow-sm w-full">
            </div>
            <div>
                <label for="sidebar_end_date" class="block text-sm font-medium">Tanggal Selesai</label>
                <input type="date" id="sidebar_end_date" name="end_date" value="{{ request('end_date', $end->toDateString()) }}" class="border-gray-300 rounded-md shadow-sm w-full">
            </div>

    <div>
        <label for="kategori_produk" class="block text-sm font-medium">Kategori Produk</label>
        <select name="kategori_produk" id="kategori_produk" class="border-gray-300 rounded-md shadow-sm w-full">
            <option value="">Semua Kategori</option>
            @foreach ($uniqueCategories as $kategori)
                <option value="{{ $kategori }}" {{ request('kategori_produk') == $kategori ? 'selected' : '' }}>
                    {{ ucfirst($kategori) }}
                </option>
            @endforeach
        </select>
    </div>
            <div>
                <label for="tag" class="block text-sm font-medium">Filter Tag</label>
                <select name="tag" id="tag" class="border-gray-300 rounded-md shadow-sm w-full">
                    <option value="">Semua Tag</option>
                    @foreach ($uniqueTags as $tag)
                        <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Terapkan Filter</button>
                <button type="button" id="closeFilterSidebar2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Tutup</button>
            </div>
        </form>
    </div>

    <div class="mb-6 p-4 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2">Total Penjualan</h2>
        <div class="text-xl font-bold text-green-700">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
    </div>

    <div class="mb-8 p-4 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Grafik Total Penjualan per Customer</h2>
        <canvas id="customerChart" height="120"></canvas>
    </div>

    <!-- <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="py-2 px-4">Tanggal</th>
                    <th class="py-2 px-4">Customer</th>
                    <th class="py-2 px-4">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d-m-Y') }}</td>
                            <td class="py-2 px-4">{{ $sale->customer->name ?? '-' }}</td>
                            <td class="py-2 px-4">Rp {{ number_format($sale->quantity * $sale->price, 0, ',', '.') }}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div> -->

    <!-- Header tabel produk (sekali di atas) -->
    <table class="min-w-full text-sm mb-4">
        <thead>
            <tr>
                <th class="py-2 px-4">Tanggal</th>
                <th class="py-2 px-4">Customer</th>
                <th class="py-2 px-4">Kuantitas</th>
                <th class="py-2 px-4">Satuan</th>
                <th class="py-2 px-4">Harga Satuan</th>
                <th class="py-2 px-4">Total</th>
            </tr>
        </thead>
    </table>

    @foreach ($groupedSales as $productName => $items)
        <h2 class="text-lg font-bold mt-8 mb-2">{{ $productName }}</h2>
        <table class="min-w-full text-sm mb-4 border border-gray-300">
        <tbody>
            @php $subtotalQty = 0; $subtotalTotal = 0; @endphp
            @foreach ($items as $item)
                @php
                    $subtotalQty += $item->quantity;
                    $subtotalTotal += $item->quantity * $item->price;
                @endphp
                <tr>
                    <td class="py-1 px-2 border border-gray-200">{{ \Carbon\Carbon::parse($item->sale_date)->format('d-m-Y') }}</td>
                    <td class="py-1 px-2 border border-gray-200">{{ $item->sale->customer->name ?? '-' }}</td>
                    <td class="py-1 px-2 border border-gray-200 text-right">{{ $item->quantity }}</td>
                    <td class="py-1 px-2 border border-gray-200">{{ $item->product->unit ?? '-' }}</td>
                    <td class="py-1 px-2 border border-gray-200 text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="py-1 px-2 border border-gray-200 text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="font-bold bg-gray-50">
                <td colspan="2" class="py-1 px-2 text-right border border-gray-300">Subtotal</td>
                <td class="py-1 px-2 text-right border border-gray-300">{{ $subtotalQty }}</td>
                <td class="py-1 px-2 border border-gray-300"></td>
                <td class="py-1 px-2 border border-gray-300"></td>
                <td class="py-1 px-2 text-right border border-gray-300">Rp {{ number_format($subtotalTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach

    @php
        $grandTotal = 0;
        foreach ($groupedSales as $items) {
            foreach ($items as $item) {
                $grandTotal += $item->quantity * $item->price;
            }
        }
    @endphp

    <div class="text-right text-xl font-bold mt-8 mb-4">
        Total Keseluruhan: <span class="text-green-700">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
    </div>

    <div class="mt-4">
        {{ $sales->withQueryString()->links() }}
    </div>

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.laporan-penjualan.pdf', request()->query()) }}"
           target="_blank"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V6m0 0l-7 7m7-7l7 7"/>
            </svg>
            Export PDF
        </a>
        <a href="{{ route('admin.laporan-penjualan.excel', request()->query()) }}"
        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
        Export Excel
        </a>
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const customerData = @json($customerTotals);

    const labels = customerData.map(c => c.customer);
    const data = customerData.map(c => c.total);

    const ctx = document.getElementById('customerChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan',
                data: data,
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Sidebar filter lanjutan
    const toggleFilterBtn = document.getElementById('toggleFilter');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterSidebarOverlay = document.getElementById('filterSidebarOverlay');
    const closeFilterSidebar = document.getElementById('closeFilterSidebar');
    const closeFilterSidebar2 = document.getElementById('closeFilterSidebar2');

    function openSidebar() {
        filterSidebar.classList.remove('translate-x-full');
        filterSidebarOverlay.classList.remove('hidden');
    }
    function closeSidebar() {
        filterSidebar.classList.add('translate-x-full');
        filterSidebarOverlay.classList.add('hidden');
    }
    toggleFilterBtn.addEventListener('click', openSidebar);
    closeFilterSidebar.addEventListener('click', closeSidebar);
    closeFilterSidebar2.addEventListener('click', closeSidebar);
    filterSidebarOverlay.addEventListener('click', closeSidebar);
</script>
@endsection
