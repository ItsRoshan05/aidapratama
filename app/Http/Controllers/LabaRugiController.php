<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;

class LabaRugiController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Default to the last 30 days if no dates are provided
        if (!$request->start_date || !$request->end_date) {
            $request->start_date = now()->subDays(30)->toDateString();
            $request->end_date = now()->toDateString();
        }
        // Get the start and end dates from the request or use defaults 

    $start = $request->start_date;
    $end = $request->end_date;

    $salesQuery = Sale::query();
    $purchaseQuery = Purchase::query();
    $expenseQuery = Expense::query();

    if ($start && $end) {
        $salesQuery->whereBetween('sale_date', [$start, $end]);
        $purchaseQuery->whereBetween('purchase_date', [$start, $end]);
        $expenseQuery->whereBetween('expense_date', [$start, $end]);
    }

    // Hitung total dari query tanpa limit (harus clone agar tidak terpengaruh limit di bawah)
    $totalSales = (clone $salesQuery)->sum('total');
    $totalPurchases = (clone $purchaseQuery)->sum('total');
    $totalExpenses = (clone $expenseQuery)->sum('amount');

    $grossProfit = $totalSales - $totalPurchases;
    $netProfit = $grossProfit - $totalExpenses;

    // Ambil 10 data terbaru untuk detail (sudah terfilter tanggal)
    $sales = (clone $salesQuery)->orderBy('sale_date', 'desc')->limit(10)->get();
    $purchases = (clone $purchaseQuery)->orderBy('purchase_date', 'desc')->limit(10)->get();
    $expenses = (clone $expenseQuery)->orderBy('expense_date', 'desc')->limit(10)->get();

    return view('admin.report.labarugi', compact(
        'totalSales',
        'totalPurchases',
        'totalExpenses',
        'grossProfit',
        'netProfit',
        'sales',
        'purchases',
        'expenses'
    ));
    }
}
