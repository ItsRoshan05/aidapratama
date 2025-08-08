<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Produk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #222; padding: 4px 8px; }
        th { background: #eee; }
        .subtotal { font-weight: bold; background: #f3f3f3; }
        h2 { margin-top: 30px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div style="text-align:center; margin-bottom: 8px;">
        <div style="font-size:18px; font-weight:bold;">AIDA PRATAMA</div>
        <div style="font-size:15px; font-weight:bold; margin-top:2px;">Penjualan dengan Produk</div>
        <div style="font-size:12px; margin-top:2px;">{{ $start->format('d-m-Y') }} s/d {{ $end->format('d-m-Y') }}</div>
        <div style="font-size:12px; margin-top:2px;">(dalam IDR)</div>
    </div>

    @php
        $grandTotal = 0;
        foreach ($groupedSales as $items) {
            foreach ($items as $item) {
                $grandTotal += $item->quantity * $item->price;
            }
        }
    @endphp

    <div style="text-align:right; font-size:14px; font-weight:bold; margin-bottom:10px;">
        Total Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}
    </div>

    @foreach ($groupedSales as $productName => $items)
        <h2>{{ $productName }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Kuantitas</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotalQty = 0; $subtotalTotal = 0; @endphp
                @foreach ($items as $item)
                    @php
                        $subtotalQty += $item->quantity;
                        $subtotalTotal += $item->quantity * $item->price;
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->sale_date)->format('d-m-Y') }}</td>
                        <td>{{ $item->sale->customer->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->unit ?? '-' }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td colspan="2" style="text-align:right;">Subtotal</td>
                    <td>{{ $subtotalQty }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($subtotalTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>
</html>