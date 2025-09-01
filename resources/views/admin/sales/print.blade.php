<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Faktur #{{ $sale->id }}</title>
    <style>
        @page {
        size: 9.5in 11in;
            }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
            padding: 4px;
        }
        .title {
            font-weight: bold;
            font-size: 16px;
        }
        .underline {
            text-decoration: underline;
        }
        .bordered, .bordered th, .bordered td {
            border: 1px solid black;
        }
        .bordered th, .bordered td {
            padding: 6px;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .no-border {
            border: none !important;
        }
    </style>
</head>
<body>

    {{-- HEADER SPLIT --}}
<table class="header-table" style="table-layout: fixed;">
    <tr>
        {{-- Kolom Kiri --}}
        <td style="width: 40%; vertical-align: top; position: relative;">
            <div style="font-weight: bold; font-size: 16px; text-decoration: underline;">AIDA PRATAMA</div>

            {{-- Spacer untuk kasih jarak antara atas dan bawah --}}
            <div style="height: 100px;"></div>

            {{-- Info kontak di bagian paling bawah kiri --}}
            <div style="position: absolute; bottom: 0;">
                <strong></strong><br>
                <strong>No Telp: 085624609832</strong> 
            </div>
        </td>

        {{-- Kolom Kanan --}}
 <td style="width: 40%;">
    <table style="width: 100%;">
        <tr>
            <!-- Kolom FAKTUR -->
            <td style="width: 50%; text-align: center;">
                <div class="title" style="font-weight: bold; font-size: 16px;">FAKTUR</div>
            </td>

            <!-- Kolom Kepada Yth -->
            <td style="width: 50%; text-align: left; font-size: 12px;">
                <strong>KEPADA YTH.</strong><br>
                {{ $sale->customer->name }}<br>
                {!! nl2br(e($sale->customer->alamat)) !!}
            </td>
        </tr>
    </table>

    <!-- Tabel Info Faktur -->
    <div style="margin-left: -100px; font-size: 11px; margin-top: 10px;">
        <table>
            <tr>
        <td style="white-space: nowrap; width: 90px;">No. Faktur</td>
        <td>: {{ $sale->invoice_number }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;">No. SO</td>
        <td>: -</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;">Reference No</td>
        <td>: Sales : {{ $sale->tag ?? '-' }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;">Tgl. Faktur</td>
        <td>: {{ \Carbon\Carbon::parse($sale->date)->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td style="white-space: nowrap;">Jatuh Tempo</td>
        <td>: {{ \Carbon\Carbon::parse($sale->deadline_date)->format('d-m-Y') }}</td>
    </tr>
<tr>
    <td style="white-space: nowrap;">Term</td>
    <td>: {{ $sale->term == 0 ? 'Cash' : 'Net' . $sale->term }}</td>
</tr>

        </table>
    </div>
</td>

    </tr>
</table>


    <br>

    {{-- TABEL PRODUK --}}
    <table class="bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th class="text-center">Qty</th>
                <th class="text-left">Kemasan</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Disk%</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($sale->items as $i => $item)
                @php
                    $jumlah = ($item->quantity * $item->price) * (1 - $item->discount / 100);
                    $total += $jumlah;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->note ?? ' ' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td>{{ $item->product->unit ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->discount }}%</td>
                    <td class="text-right">{{ number_format($jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
         </tfoot>
    </table>

    {{-- TERBILANG & TOTAL-NETTO --}}
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 50%; border: 1px solid black; vertical-align: top;">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 4px;"><strong>TERBILANG</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;">{{ App\Helpers\Terbilang::rupiah($total) }} Rupiah</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: right; padding: 4px;"><strong>Total</strong></td>
                        <td style="text-align: right; padding: 4px;"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding: 4px;"><strong>Netto</strong></td>
                        <td style="text-align: right; padding: 4px;"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br><br>

    {{-- TANDA TANGAN --}}
    <table style="width: 100%; text-align: center; margin-top: 60px;">
        <tr>
            <td style="width: 20%;">
                Diterima oleh<br><br><br><br><br>
                <strong></strong>
            </td>
            <td style="border: 1px solid black; width: 60%; text-align: left; vertical-align: top;">
                Perhatian,<br>
                <p>{{ $sale->note ?? ' ' }}</p>
            </td>
            <td style="width: 50%;">
                Hormat Kami<br><br><br><br><br>
                <strong></strong>
            </td>
        </tr>
    </table>

<script>
    window.onload = function () {
        window.print();
    }
</script>
