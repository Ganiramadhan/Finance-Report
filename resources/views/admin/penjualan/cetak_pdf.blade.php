<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA PENJUALAN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr td,
        table tr th {
            font-size: 9pt;
            border: 1px solid #ccc;
            padding: 8px;
        }

        table th {
            background-color: #f2f2f2;
            align-items: center;
            text-align: center;
        }

        /* Set orientasi halaman menjadi landscape */
        @page {
            size: landscape;
        }
    </style>
</head>

<body>
    <center>
        <h4>MEGA KREASI INDONESIA</h4>
        <h5>DATA PENJUALAN</h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Customer</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Total Harga</th>
                <th>Diskon</th>
                <th>Pembayaran</th>
                <th>Sisa Piutang</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @php $totalPembayaran = 0 @endphp
            @foreach ($data_penjualan as $penjualan)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $penjualan->customer->nama }}</td>
                    <td>{{ $penjualan->product->nama }}</td>
                    <td>{{ 'Rp ' . number_format($penjualan->product->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $penjualan->qty }}</td>
                    <td>{{ $penjualan->product->satuan }}</td>
                    <td>{{ 'Rp ' . number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($penjualan->diskon, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($penjualan->pembayaran, 0, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($penjualan->piutang, 0, ',', '.') }}</td>
                    <td>{{ $penjualan->metode_pembayaran->metode_pembayaran }}</td>
                    <td>{{ $penjualan->tanggal }}</td>
                </tr>
                @php
                    $totalPembayaran += $penjualan->pembayaran;
                @endphp
            @endforeach
            <tr>
                <td colspan="8"><strong>
                        <center>TOTAL PEMBAYARAN</center>
                    </strong></td>
                <td colspan="4"><strong> {{ 'Rp ' . number_format($totalPembayaran, 0, ',', '.') }}</strong></td>


            </tr>
        </tbody>
    </table>

</body>

</html>
