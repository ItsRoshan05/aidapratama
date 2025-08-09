<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total produk
        $totalProducts = Product::count();

        // === Hitung Laba Rugi All Time ===
        $totalSales = Sale::sum('total'); // Total Penjualan
        $totalPurchases = Purchase::sum('total'); // Total Pembelian
        $totalExpenses = Expense::sum('amount'); // Total Pengeluaran

        $grossProfit = $totalSales - $totalPurchases; // Laba Kotor
        $netProfit = $grossProfit - $totalExpenses;   // Laba Bersih

        // === Data penjualan per bulan untuk chart ===
        $monthlySales = Sale::select(
            DB::raw('SUM(total) as total'),
            DB::raw("DATE_FORMAT(sale_date,'%m') as month")
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();

        $months = [];
        $salesData = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create(null, $m, 1)->format('M');
            $salesData[] = $monthlySales[sprintf("%02d", $m)] ?? 0;
        }

        // Statistik supplier (all time)
        $supplierStats = Purchase::select('supliers.name', DB::raw('COUNT(DISTINCT purchases.id) as total'))
            ->join('supliers', 'purchases.suplier_id', '=', 'supliers.id')
            ->groupBy('supliers.id', 'supliers.name')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalSales',
            'totalPurchases',
            'totalExpenses',
            'grossProfit',
            'netProfit',
            'months',
            'salesData',
            'supplierStats'
        ));
    }
}
