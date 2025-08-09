@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Produk</p>
            <h3 class="text-2xl font-bold text-blue-600">{{ number_format($totalProducts) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Penjualan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
        </div>
        @if(Auth::user()->role === 'owner')
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-200 flex flex-col items-center">
            <p class="text-gray-500 mb-2">Total Laba</p>
            <h3 class="text-2xl font-bold text-pink-600">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
        </div>
        @endif
    </div>
    <div class="grid grid-cols-1 md:grid-cols-7 gap-6 mb-8">
        <div class="md:col-span-5 p-6 bg-white rounded-2xl shadow flex flex-col items-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Statistik Penjualan</h2>
            <h3 class="text-lg font-semibold mb-2 text-blue-700">Penjualan Bulanan {{ Carbon\Carbon::now()->year }}</h3>
            <canvas id="salesChart" class="w-full max-w-lg h-48"></canvas>
        </div>
        <div class="md:col-span-2 p-6 bg-white rounded-2xl shadow flex flex-col items-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Statistik Suplier</h2>
            <h3 class="text-lg font-semibold mb-2 text-yellow-700">Distribusi Produk Suplier</h3>
            <canvas id="supplierChart" class="w-full max-w-xs h-48"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sales Chart
            const chartEl = document.getElementById('salesChart');
            if (window.Chart && chartEl) {
                const ctx = chartEl.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Total Penjualan',
                            data: @json($salesData),
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: false }
                        },
                        scales: {
                            x: {
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                },
                                grid: { color: '#e5e7eb' }
                            }
                        }
                    }
                });
            }

            // Supplier Pie Chart
            const supplierEl = document.getElementById('supplierChart');
            if (window.Chart && supplierEl) {
                const supplierCtx = supplierEl.getContext('2d');
                const supplierData = @json($supplierStats);
                new Chart(supplierCtx, {
                    type: 'pie',
                    data: {
                        labels: supplierData.map(item => item.name),
                        datasets: [{
                            label: 'Jumlah Produk',
                            data: supplierData.map(item => item.total),
                            backgroundColor: [
                                '#f59e42',
                                '#10b981',
                                '#6366f1',
                                '#ef4444'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: { boxWidth: 20 }
                            },
                            title: { display: false }
                        }
                    }
                });
            }
        });
    </script>
@endsection
