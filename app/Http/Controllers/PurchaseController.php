<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Suplier;
use App\Models\Purchase;
use App\Models\PurchaseItem as PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function index()
    {
        $purchases = Purchase::with('suplier')->get();
        return view('admin.purchases.index', compact('purchases'));
    }
    
    public function create()
    {
        $supliers = Suplier::all();
        $products = Product::all();
        // Generate invoice number: INV-YYYYMMDD-XXXX
        $date = date('Ymd');
        $last = Purchase::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_number = 'INV-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        return view('admin.purchases.create', compact('supliers', 'products', 'invoice_number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'suplier_id' => 'required|exists:supliers,id',
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'purchase_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0|max:100',
        ], [
            'invoice_number.unique' => 'Nomor invoice sudah digunakan, silakan gunakan nomor lain.'
        ]);

        // Generate invoice number: INV-YYYYMMDD-XXXX
        $date = date('Ymd');
        $last = Purchase::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_number = 'INV-B-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);

$purchaseId = null;

DB::transaction(function () use ($request, $invoice_number, &$purchaseId) {
    $purchase = Purchase::create([
        'suplier_id' => $request->suplier_id,
        'invoice_number' => $request->invoice_number,
        'purchase_date' => $request->purchase_date,
        'deskripsi' => $request->deskripsi,
        'total' => 0,
    ]);

    $purchaseId = $purchase->id;

    $total = 0;

    foreach ($request->products as $item) {
        $discount = isset($item['discount']) ? floatval($item['discount']) : 0;
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $quantity * $price * (1 - ($discount / 100));
        $total += $subtotal;

        PurchaseDetail::create([
            'purchase_id' => $purchase->id,
            'product_id' => $item['product_id'],
            'quantity' => $quantity,
            'price' => $price,
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);

        $product = Product::find($item['product_id']);
        $product->increment('stock', $quantity);
    }

    $purchase->update(['total' => $total]);
});

return redirect()
    ->route('admin.purchases.index')
    ->with('success', 'Pembelian berhasil ditambahkan.')
    ->with('print_id', $purchaseId);

    }

    public function edit($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);
        $supliers = Suplier::all();
        $products = Product::all();
        return view('admin.purchases.edit', compact('purchase', 'supliers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'suplier_id' => 'required|exists:supliers,id',
            'purchase_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $purchase = Purchase::with('items')->findOrFail($id);

        DB::transaction(function () use ($request, $purchase) {
            // Rollback stok lama
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                $product->decrement('stock', $item->quantity);
            }

            // Update data utama
            $purchase->update([
                'suplier_id' => $request->suplier_id,
                'purchase_date' => $request->purchase_date,
                'deskripsi' => $request->deskripsi,
            ]);

            // Hapus semua item lama
            $purchase->items()->delete();

            $total = 0;
            foreach ($request->products as $item) {
                $discount = isset($item['discount']) ? floatval($item['discount']) : 0;
                $price = floatval($item['price']);
                $quantity = intval($item['quantity']);
                $subtotal = $quantity * $price * (1 - ($discount / 100));
                $total += $subtotal;

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['product_id']);
                $product->increment('stock', $quantity);
            }

            $purchase->update(['total' => $total]);
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil diupdate.');
    }

    public function show($id)
    {
        $purchase = Purchase::with(['suplier', 'items.product'])->findOrFail($id);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                // Kurangi stok produk
                $product = Product::find($item->product_id);
                $product->decrement('stock', $item->quantity);
            }
            $purchase->delete();
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function print($id)
{
    $purchase = Purchase::with(['suplier', 'items.product'])->findOrFail($id);
    return view('admin.purchases.print', compact('purchase'));
}

}
