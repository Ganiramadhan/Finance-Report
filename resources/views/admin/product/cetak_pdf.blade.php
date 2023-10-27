<!DOCTYPE html>
<html>

<head>
    <title>MEGA KREASI INDONESIA - DATA PRODUK</title>
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
    </style>
    <center>
        <h5>MEGA KREASI INDONESIA</h4>
            <h6>DATA PRODUK
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Produk</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Total Harga</th>
                <th>Harga Jual</th>

            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($data_products as $product)
                <tr>
                    <td class="align-middle">{{ $product->id }}</td>
                    <td class="align-middle">{{ $product->nama }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($product->hrg_beli, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $product->qty }} {{ $product->satuan }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($product->total, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
