<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA PEMBELIAN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
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
    <center>
        <h5>MEGA KREASI INDONESIA</h5>
        <h6>DATA PEMBELIAN</h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Kode Transaksi</th>
                <th>Nama Produk</th>
                <th>Harga Produk</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Total Harga</th>
                <th>Total Belanja</th>
                <th>Diskon</th>
                <th>Total Bayar</th>
                <th>Pembayaran</th>
                <th>Nama Supplier</th>
                <th>Utang</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @php $totalPembayaran = 0 @endphp
            @foreach ($data_pembelian as $pembelian)
                <tr>
                    <td class="align-middle">{{ $i++ }}</td>
                    <td class="align-middle">{{ $pembelian->kd_transaksi }}</td>
                    <td class="align-middle">{{ $pembelian->product->nama }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->product->hrg_beli, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $pembelian->qty }}</td>
                    <td class="align-middle">{{ $pembelian->product->satuan }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->total_belanja, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->diskon, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->pembayaran, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $pembelian->supplier->nama }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $pembelian->metode_pembayaran->metode_pembayaran }}</td>
                    <td class="align-middle">{{ $pembelian->tanggal }}</td>
                </tr>
                @php
                    $totalPembayaran += $pembelian->pembayaran;
                @endphp
            @endforeach
            <tr>
                <td colspan="10"><strong>
                        <center>TOTAL PEMBAYARAN</center>
                    </strong></td>
                <td colspan="5">
                    <strong>{{ 'Rp ' . number_format($totalPembayaran, 0, ',', '.') }}</strong>
                </td>

            </tr>
        </tbody>
    </table>

</body>

</html>
