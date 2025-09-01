<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    //
        public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $date = date('Ymd');
        $last = Sale::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_number = 'INV-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        return view('admin.sales.create', compact('products', 'customers', 'invoice_number'));
    }


public function store(Request $request)
{
    $request->validate([
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.price' => 'required|numeric|min:0',
        'products.*.discount' => 'nullable|integer|min:0|max:100',
        'sale_date' => 'required|date',
        'customer_id' => 'required|exists:customers,id',
        'note' => 'nullable|string|max:255',
        'term' => 'required|integer|in:0,7,15,30',
    ]);

    DB::beginTransaction();
    try {
        $total = 0;
        $items = [];

        foreach ($request->products as $item) {
            $qty = $item['quantity'];
            $price = $item['price'];
            $discount = $item['discount'] ?? 0;

            $subtotal = ($price * $qty) - (($price * $qty * $discount) / 100);
            $total += $subtotal;

            $items[] = [
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'price' => $price,
                'discount' => $discount,
                'subtotal' => $subtotal,
            ];
        }

        // Generate invoice number
        $date = date('Ymd');
        $last = Sale::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_number = 'INV-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);

        // Hitung deadline_date dari sale_date + term
        $saleDate = Carbon::parse($request->sale_date);
        $term = (int) $request->term;
        $deadlineDate = $saleDate->copy()->addDays($term);

        $sale = Sale::create([
            'invoice_number' => $invoice_number,
            'customer_id' => $request->customer_id,
            'tag' => $request->tag,
            'sale_date' => $saleDate,
            'term' => $term,
            'deadline_date' => $deadlineDate,
            'total' => $total,
            'note' => $request->note,
        ]);

        foreach ($items as $item) {
            $item['sale_id'] = $sale->id;
            SaleItem::create($item);

            // Kurangi stok produk
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        DB::commit();
        return redirect()->route('admin.sales.index')->with([
            'success' => 'Penjualan berhasil disimpan.',
            'print_id' => $sale->id,
        ]);
    } catch (\Throwable $th) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan penjualan: ' . $th->getMessage());
    }
}


    public function show(Sale $sale)
    {
        $sale->load(['customer', 'items.product']);
        return view('admin.sales.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::with('items')->findOrFail($id);
        $products = Product::all();
        $customers = Customer::all();
        return view('admin.sales.edit', compact('sale', 'products', 'customers'));
    }

    public function update(Request $request, $id){
 
    $request->validate([
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.price' => 'required|integer|min:0',
        'products.*.discount' => 'nullable|integer|min:0|max:100',
        'sale_date' => 'required|date',
        'customer_id' => 'nullable|exists:customers,id',
        'tag' => 'nullable|string|max:255',
        'term' => 'required|integer|in:0,7,15,30', // tambahkan validasi term
    ]);

    $sale = Sale::with('items')->findOrFail($id);

    // Rollback stok lama
    foreach ($sale->items as $item) {
        $product = Product::find($item->product_id);
        if ($product) {
            $product->increment('stock', $item->quantity);
        }
    }

    // Hitung deadline_date baru
    $saleDate = \Carbon\Carbon::parse($request->sale_date);
    $term = (int) $request->term;
    $deadlineDate = $saleDate->copy()->addDays($term);

    $sale->update([
        'customer_id' => $request->customer_id,
        'tag' => $request->tag,
        'sale_date' => $saleDate,
        'term' => $term,
        'deadline_date' => $deadlineDate,
        'note' => $request->note,
    ]);

    // Hapus item lama
    $sale->items()->delete();

    $total = 0;
    foreach ($request->products as $item) {
        $qty = $item['quantity'];
        $price = $item['price'];
        $discount = $item['discount'] ?? 0;

        $subtotal = ($price * $qty) - (($price * $qty * $discount) / 100);
        $total += $subtotal;

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $item['product_id'],
            'quantity' => $qty,
            'price' => $price,
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stok produk
        $product = Product::find($item['product_id']);
        if ($product) {
            $product->decrement('stock', $qty);
        }
    }

    // Update total penjualan
    $sale->update(['total' => $total]);

    return redirect()->route('admin.sales.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->items()->each(function ($item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        });
        $sale->delete();

        return redirect()->route('admin.sales.index')->with('success', 'Penjualan berhasil dihapus.');
    }
    public function print($id)
{
    $sale = Sale::with(['Customer', 'items.product'])->findOrFail($id);
    return view('admin.sales.print', compact('sale'));
}
}
