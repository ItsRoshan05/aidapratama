<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualanController extends Controller
{
public function index(Request $request)
{
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'tag' => 'nullable|string',
        'kategori_produk' => 'nullable|string',
    ]);

    // Default tanggal
    if (!$request->start_date || !$request->end_date) {
        $request->start_date = now()->subDays(30)->toDateString();
        $request->end_date = now()->toDateString();
    }

    $start = now()->parse($request->start_date)->startOfDay();
    $end = now()->parse($request->end_date)->endOfDay();

    $salesQuery = Sale::with(['customer', 'items.product'])
        ->whereBetween('sale_date', [$start, $end]);

    // Filter tag
    if ($request->filled('tag')) {
        $salesQuery->where('tag', $request->tag);
    }

    // Filter kategori produk dari relasi product
    if ($request->filled('kategori_produk')) {
        $salesQuery->whereHas('items.product', function ($query) use ($request) {
            $query->where('category', $request->kategori_produk);
        });
    }

    $totalSales = (clone $salesQuery)->sum('total');

    $sales = (clone $salesQuery)
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    // Data chart
    $customerTotals = (clone $salesQuery)
        ->selectRaw('customer_id, SUM(total) as total')
        ->groupBy('customer_id')
        ->with('customer')
        ->get()
        ->map(function ($sale) {
            return [
                'customer' => optional($sale->customer)->name ?? 'Tidak diketahui',
                'total' => $sale->total,
            ];
        });

    // Ambil unique tag
    $uniqueTags = DB::table('sales')
        ->whereNotNull('tag')
        ->where('tag', '!=', '')
        ->select('tag')
        ->distinct()
        ->pluck('tag');

    // Ambil kategori unik dari tabel products
    $uniqueCategories = DB::table('products')
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->select('category')
        ->distinct()
        ->pluck('category');


$filteredItems = $sales->getCollection()
    ->flatMap->items
    ->filter(function ($item) use ($request) {
        $kategoriOk = true;
        $tagOk = true;
        if ($request->filled('kategori_produk')) {
            $kategoriOk = $item->product->category == $request->kategori_produk;
        }
        if ($request->filled('tag')) {
            $tagOk = $item->sale->tag == $request->tag;
        }
        return $kategoriOk && $tagOk;
    });

$groupedSales = $filteredItems->groupBy(fn($item) => $item->product->name);

    return view('admin.report.penjualan', compact(
        'totalSales',
        'sales',
        'start',
        'end',
        'customerTotals',
        'uniqueTags',
        'uniqueCategories',
        'groupedSales'
    ));
}


public function exportPdf(Request $request)
{
    // Copy logic dari index() untuk filter dan grouping
    // ... (sama seperti index, ambil $groupedSales, $start, $end, dll)

    // --- copy dari index() ---
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'tag' => 'nullable|string',
        'kategori_produk' => 'nullable|string',
    ]);
    if (!$request->start_date || !$request->end_date) {
        $request->start_date = now()->subDays(30)->toDateString();
        $request->end_date = now()->toDateString();
    }
    $start = now()->parse($request->start_date)->startOfDay();
    $end = now()->parse($request->end_date)->endOfDay();
    $salesQuery = Sale::with(['customer', 'items.product'])
        ->whereBetween('sale_date', [$start, $end]);
    if ($request->filled('tag')) {
        $salesQuery->where('tag', $request->tag);
    }
    if ($request->filled('kategori_produk')) {
        $salesQuery->whereHas('items.product', function ($query) use ($request) {
            $query->where('category', $request->kategori_produk);
        });
    }
    $sales = (clone $salesQuery)
        ->orderBy('created_at', 'desc')
        ->get();
    $filteredItems = $sales
        ->flatMap->items
        ->filter(function ($item) use ($request) {
            $kategoriOk = true;
            $tagOk = true;
            if ($request->filled('kategori_produk')) {
                $kategoriOk = $item->product->category == $request->kategori_produk;
            }
            if ($request->filled('tag')) {
                $tagOk = $item->sale->tag == $request->tag;
            }
            return $kategoriOk && $tagOk;
        });
    $groupedSales = $filteredItems->groupBy(fn($item) => $item->product->name);
    // --- end copy ---




$pdf = Pdf::loadView('admin.report.penjualan_pdf', compact('groupedSales', 'start', 'end'));
return $pdf->download('laporan-penjualan.pdf');
}




public function exportExcel(Request $request)
{
    // Copy logic filter & grouping dari index/exportPdf
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'tag' => 'nullable|string',
        'kategori_produk' => 'nullable|string',
    ]);
    if (!$request->start_date || !$request->end_date) {
        $request->start_date = now()->subDays(30)->toDateString();
        $request->end_date = now()->toDateString();
    }
    $start = now()->parse($request->start_date)->startOfDay();
    $end = now()->parse($request->end_date)->endOfDay();
    $salesQuery = Sale::with(['customer', 'items.product'])
        ->whereBetween('sale_date', [$start, $end]);
    if ($request->filled('tag')) {
        $salesQuery->where('tag', $request->tag);
    }
    if ($request->filled('kategori_produk')) {
        $salesQuery->whereHas('items.product', function ($query) use ($request) {
            $query->where('category', $request->kategori_produk);
        });
    }
    $sales = (clone $salesQuery)
        ->orderBy('created_at', 'desc')
        ->get();
    $filteredItems = $sales
        ->flatMap->items
        ->filter(function ($item) use ($request) {
            $kategoriOk = true;
            $tagOk = true;
            if ($request->filled('kategori_produk')) {
                $kategoriOk = $item->product->category == $request->kategori_produk;
            }
            if ($request->filled('tag')) {
                $tagOk = $item->sale->tag == $request->tag;
            }
            return $kategoriOk && $tagOk;
        });
    $groupedSales = $filteredItems->groupBy(fn($item) => $item->product->name);

    // Export pakai view
    return Excel::download(new class($groupedSales, $start, $end) implements \Maatwebsite\Excel\Concerns\FromView {
        private $groupedSales, $start, $end;
        public function __construct($groupedSales, $start, $end)
        {
            $this->groupedSales = $groupedSales;
            $this->start = $start;
            $this->end = $end;
        }
        public function view(): \Illuminate\Contracts\View\View
        {
            return view('admin.report.penjualan_excel', [
                'groupedSales' => $this->groupedSales,
                'start' => $this->start,
                'end' => $this->end,
            ]);
        }
    }, 'laporan-penjualan.xlsx');
}



}
