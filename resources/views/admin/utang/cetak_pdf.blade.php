<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA UTANG</title>
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
        <h6>DATA UTANG</h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Supplier</th>
                <th>Jumlah Utang</th>
                <th>Pembayaran</th>
                <th>Sisa Utang</th>
                <th>Keterangan</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $totalPembayaran = 0; // Inisialisasi total pembayaran
            @endphp
            @foreach ($data_utang as $utang)
                <tr>
                    <td class="align-middle">{{ $i++ }}</td>
                    <td class="align-middle">{{ $utang->supplier->nama }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($utang->jumlah_utang, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($utang->pembayaran, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($utang->sisa_utang, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $utang->keterangan }}</td>
                    <td class="align-middle">{{ $utang->metode_pembayaran->metode_pembayaran }}</td>
                    <td class="align-middle">{{ $utang->tanggal }}</td>
                </tr>
                @php
                    $totalPembayaran += $utang->pembayaran; // Menambahkan pembayaran ke total
                @endphp
            @endforeach
            <tr>
                <td colspan="3"><strong>
                        <center>TOTAL PEMBAYARAN</center>
                    </strong></td>
                <td colspan="5"><strong>{{ 'Rp ' . number_format($totalPembayaran, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
