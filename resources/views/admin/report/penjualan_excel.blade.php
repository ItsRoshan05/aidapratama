

<table>
    <tr>
        <td colspan="6" style="font-size:18px; font-weight:bold; text-align:center;">AIDA PRATAMA</td>
    </tr>
    <tr>
        <td colspan="6" style="font-size:15px; font-weight:bold; text-align:center;">Penjualan dengan Produk</td>
    </tr>
    <tr>
        <td colspan="6" style="font-size:12px; text-align:center;">{{ $start->format('d-m-Y') }} s/d {{ $end->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td colspan="6" style="font-size:12px; text-align:center;">(dalam IDR)</td>
    </tr>
</table>

@php
    $grandTotal = 0;
    foreach ($groupedSales as $items) {
        foreach ($items as $item) {
            $grandTotal += $item->quantity * $item->price;
        }
    }
@endphp

<table>
    <tr>
        <td colspan="6" style="text-align:right; font-weight:bold;">
            Total Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}
        </td>
    </tr>
</table>

@foreach ($groupedSales as $productName => $items)
    <table>
        <tr>
            <td colspan="6" style="font-weight:bold; font-size:14px;">{{ $productName }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Kuantitas</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Total</th>
        </tr>
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
        <tr>
            <td colspan="2" style="text-align:right; font-weight:bold;">Subtotal</td>
            <td style="font-weight:bold;">{{ $subtotalQty }}</td>
            <td></td>
            <td></td>
            <td style="font-weight:bold;">{{ number_format($subtotalTotal, 0, ',', '.') }}</td>
        </tr>
    </table>
@endforeach