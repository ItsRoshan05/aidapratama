@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Laporan Pembelian</h1>

    <form method="GET" class="mb-6 flex gap-4 items-end">
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
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Filter</button>
    </form>

    <div class="mb-6 p-4 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2">Total Pembelian</h2>
        <div class="text-xl font-bold text-green-700">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</div>
    </div>

    <div class="mb-8 p-4 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Grafik Total Pembelian per Supplier</h2>
        <canvas id="supplierChart" height="120"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="py-2 px-4">Tanggal</th>
                    <th class="py-2 px-4">Supplier</th>
                    <th class="py-2 px-4">Total</th>
                    <th class="py-2 px-4">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}</td>
                    <td class="py-2 px-4">{{ $purchase->suplier->name ?? '-' }}</td>
                    <td class="py-2 px-4">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">{{ $purchase->note }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">Tidak ada data pembelian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $purchases->withQueryString()->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const supplierData = @json($supplierTotals);

    const labels = supplierData.map(s => s.supplier);
    const data = supplierData.map(s => s.total);

    const ctx = document.getElementById('supplierChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Pembelian',
                data: data,
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgba(59, 130, 246, 1)',
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
</script>
@endsection
