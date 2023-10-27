<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA PEMBAYARAN</title>
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
        <h6>DATA PEMBAYARAN</h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Kode Pembayaran</th>
                <th>Kategori Pengeluaran</th>
                <th>Penerima</th>
                <th>Keterangan</th>
                <th>Jumlah Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $totalPembayaran = 0; // Inisialisasi total pembayaran
            @endphp
            @foreach ($data_pembayaran as $pembayaran)
                <tr>
                    <td class="align-middle">{{ $i++ }}</td>
                    <td class="align-middle">{{ $pembayaran->kd_pembayaran }}</td>
                    <td class="align-middle">{{ $pembayaran->kategori_pengeluaran->nama_kategori }}</td>
                    <td class="align-middle">{{ $pembayaran->penerima }}</td>
                    <td class="align-middle">{{ $pembayaran->keterangan }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($pembayaran->jml_pembayaran, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $pembayaran->metode_pembayaran->metode_pembayaran }}</td>
                    <td class="align-middle">{{ $pembayaran->tanggal }}</td>
                </tr>
                @php
                    
                    $totalPembayaran += $pembayaran->jml_pembayaran; // Menambahkan jumlah pembayaran ke total
                @endphp
            @endforeach
            <tr>
                <td colspan="5"><strong>
                        <center>TOTAL PEMBAYARAN</center>
                    </strong></td>
                <td colspan="3"><strong>{{ 'Rp ' . number_format($totalPembayaran, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
