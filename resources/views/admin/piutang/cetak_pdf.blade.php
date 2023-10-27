<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA PIUTANG</title>
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
        <h6>DATA PIUTANG</h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Customer</th>
                <th>Jumlah Piutang</th>
                <th>Sisa Piutang</th>
                <th>Pembayaran</th>
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
            @foreach ($data_piutang as $piutang)
                <tr>
                    <td class="align-middle">{{ $i++ }}</td>
                    <td class="align-middle">{{ $piutang->customer->nama }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($piutang->jumlah_piutang, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($piutang->sisa_piutang, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($piutang->pembayaran, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $piutang->keterangan }}</td>
                    <td class="align-middle">{{ $piutang->metode_pembayaran->metode_pembayaran }}</td>
                    <td class="align-middle">{{ $piutang->tanggal }}</td>
                </tr>
                @php
                    $totalPembayaran += $piutang->pembayaran; // Menambahkan pembayaran ke total
                @endphp
            @endforeach
            <tr>
                <td colspan="4"><strong>
                        <center>TOTAL PEMBAYARAN</center>
                    </strong></td>
                <td colspan="4"><strong>{{ 'Rp ' . number_format($totalPembayaran, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
