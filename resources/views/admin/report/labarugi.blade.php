@extends('layouts.app')

@section('title', 'Laba Rugi')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-md">
    <h2 class="text-2xl font-bold mb-8 text-gray-800 text-center">Laba Rugi</h2>

       {{-- Filter Tanggal --}}
    <form method="GET" class="mb-6 flex flex-col md:flex-row items-center justify-center gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="mt-6 md:mt-5">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">Terapkan Filter</button>
        </div>
    </form>

    <div x-data="{ tab: 'summary' }" class="">
        <div class="flex justify-center mb-6">
            <button @click="tab = 'summary'" :class="tab === 'summary' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-l-md font-semibold transition-colors duration-200 focus:outline-none">Ringkasan</button>
            <button @click="tab = 'detail'" :class="tab === 'detail' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-r-md font-semibold transition-colors duration-200 focus:outline-none">Detail</button>
        </div>

        <!-- Ringkasan -->
        <div x-show="tab === 'summary'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="flex items-center gap-4 p-4 bg-green-50 border border-green-100 rounded-lg shadow-sm">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0 0c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/></svg>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Total Penjualan</div>
                        <div class="text-xl font-semibold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-red-50 border border-red-100 rounded-lg shadow-sm">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Total Pembelian</div>
                        <div class="text-xl font-semibold text-red-600">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-yellow-50 border border-yellow-100 rounded-lg shadow-sm">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Total Biaya Operasional</div>
                        <div class="text-xl font-semibold text-yellow-600">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-blue-50 border border-blue-100 rounded-lg shadow-sm">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18"/></svg>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm">Laba Kotor</div>
                        <div class="text-xl font-semibold text-blue-600">Rp {{ number_format($grossProfit, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col items-center justify-center">
                <div class="w-full md:w-2/3 bg-gradient-to-r from-indigo-100 to-indigo-50 border border-indigo-200 rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        <span class="text-lg text-indigo-700 font-semibold">Laba Bersih</span>
                    </div>
                    <div class="text-3xl font-bold text-indigo-700">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div x-show="tab === 'detail'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="">
            <div class="mb-8">
                <!-- Menampilkan note bahwa hanya 10 data saja yang ditampilkan -->
                 <div class="text-xs text-gray-400 mb-2">Menampilkan 10 data terbaru</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18"/></svg> List Penjualan</h3>
                <div class="overflow-x-auto rounded-lg border border-green-100 bg-green-50">
                    <table class="min-w-full text-sm">
                        <thead class="bg-green-100 text-green-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">No Invoice</th>
                                <th class="px-4 py-2 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr class="hover:bg-green-100/60">
                                <td class="px-4 py-2">{{ $sale->created_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.sales.show', $sale->id) }}" class="text-blue-600 hover:underline" target="_blank">{{ $sale->invoice_number }}</a>
                                </td>
                                <td class="px-4 py-2">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-gray-400 py-2">Tidak ada data penjualan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg> List Pembelian</h3>
                <div class="overflow-x-auto rounded-lg border border-red-100 bg-red-50">
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-100 text-red-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">No Invoice</th>
                                <th class="px-4 py-2 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                            <tr class="hover:bg-red-100/60">
                                <td class="px-4 py-2">{{ $purchase->created_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="text-blue-600 hover:underline" target="_blank">{{ $purchase->invoice_number }}</a>
                                </td>
                                <td class="px-4 py-2">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-gray-400 py-2">Tidak ada data pembelian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg> List Biaya Operasional</h3>
                <div class="overflow-x-auto rounded-lg border border-yellow-100 bg-yellow-50">
                    <table class="min-w-full text-sm">
                        <thead class="bg-yellow-100 text-yellow-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Nama Biaya</th>
                                <th class="px-4 py-2 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr class="hover:bg-yellow-100/60">
                                <td class="px-4 py-2">{{ $expense->created_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $expense->name }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-gray-400 py-2">Tidak ada data biaya operasional.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-center">
        <a href="{{ route('admin.products.index') }}" class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow">← Kembali ke Dashboard</a>
    </div>
</div>
@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection
