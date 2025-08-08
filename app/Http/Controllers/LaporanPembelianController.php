<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if (!$request->start_date || !$request->end_date) {
            $request->start_date = now()->subDays(30)->toDateString();
            $request->end_date = now()->toDateString();
        }

        $start = now()->parse($request->start_date)->startOfDay();
        $end = now()->parse($request->end_date)->endOfDay();

        $purchasesQuery = Purchase::with('suplier')
            ->whereBetween('created_at', [$start, $end]);

        $totalPurchases = (clone $purchasesQuery)->sum('total');

        $purchases = (clone $purchasesQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Chart data
        $supplierTotals = (clone $purchasesQuery)
            ->selectRaw('suplier_id, SUM(total) as total')
            ->groupBy('suplier_id')
            ->with('suplier')
            ->get()
            ->map(function ($purchase) {
                return [
                    'supplier' => optional($purchase->suplier)->name ?? 'Tidak diketahui',
                    'total' => $purchase->total,
                ];
            });

        return view('admin.report.pembelian', compact(
            'totalPurchases',
            'purchases',
            'start',
            'end',
            'supplierTotals'
        ));
    }
}
