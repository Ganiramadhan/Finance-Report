<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA TRANSAKSI</title>
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
        <h6>DATA TRANSAKSI</h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Kode Transaksi</th>
                <th>Jenis Transaksi</th>
                <th>Metode Pembayaran</th>
                <th>Keterangan</th>
                <th>Jumlah Transaksi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $totalJumlahTransaksi = 0; // Inisialisasi total jumlah transaksi
            @endphp
            @foreach ($data_transaksi as $transaksi)
                @php
                    $jenisTransaksi = $transaksi->jenis_transaksi->jenis_transaksi;
                    $jumlah = $transaksi->jumlah;
                    
                    // Cek apakah jenis transaksi adalah "Penerimaan Piutang" atau "Penerimaan Pinjaman"
                    if ($jenisTransaksi === 'Penerimaan Piutang' || $jenisTransaksi === 'Penerimaan Pinjaman') {
                        // Kurangkan dari total jika jenis transaksi ini
                        $totalJumlahTransaksi -= $jumlah;
                    } else {
                        // Tambahkan ke total jika bukan jenis transaksi ini
                        $totalJumlahTransaksi += $jumlah;
                    }
                @endphp
                <tr>
                    <td class="align-middle">{{ $i++ }}</td>
                    <td class="align-middle">{{ $transaksi->kd_transaksi }}</td>
                    <td class="align-middle">{{ $jenisTransaksi }}</td>
                    <td class="align-middle">{{ $transaksi->metode_pembayaran->metode_pembayaran }}</td>
                    <td class="align-middle">{{ $transaksi->keterangan }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($jumlah, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $transaksi->tanggal }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>
                        <center>TOTAL TRANSAKSI</center>
                    </strong></td>
                <td colspan="2">
                    <strong>{{ 'Rp ' . number_format($totalJumlahTransaksi, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <p><i>Note: Jumlah Transaksi akan dikurangkan jika Jenis Transaksi adalah Penerimaan Piutang atau Penerimaan
            Pinjaman</i></p>
</body>

</html>
