<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $purchase->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        @page {
            size: A5 portrait;
            margin: 1cm;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 4px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .no-border td {
            border: none;
            padding: 4px 2px;
        }

        .signature {
            margin-top: 30px;
            width: 100%;
        }

        .signature td {
            border: none;
            vertical-align: top;
            height: 80px;
        }

        .signature .center {
            text-align: center;
        }

        .perhatian {
            margin-top: 10px;
            font-size: 11px;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="{{ asset('img/logodrhpolos.png') }}" alt="Logo" class="header-logo">
        <h2>AIDA PRATAMA</h2>
        <p><strong>INVOICE PEMBELIAN</strong></p>
        <p>No: {{ $purchase->invoice_number }}</p>
    </div>

    <table class="no-border">
        <tr>
            <td><strong>Supplier</strong></td>
            <td>: {{ $purchase->suplier->name }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ date('d-m-Y', strtotime($purchase->purchase_date)) }}</td>
        </tr>
        @if($purchase->deskripsi)
        <tr>
            <td><strong>Deskripsi</strong></td>
            <td>: {{ $purchase->deskripsi }}</td>
        </tr>
        @endif
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->discount }}%</td>
                <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right">Total</th>
                <th>Rp{{ number_format($purchase->total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <table class="signature">
        <tr>
            <td class="center">
                <strong>Penerima</strong><br><em>(Cap / Tanda Tangan)</em>
            </td>
            <td class="center">
                <strong>Hormat Kami</strong><br><em>AIDA PRATAMA</em>
            </td>
        </tr>
    </table>

    <div class="perhatian">
        <strong>Perhatian:</strong>
        <p>Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada perjanjian sebelumnya.</p>
    </div>

</body>
</html>
