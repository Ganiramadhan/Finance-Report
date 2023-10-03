@extends('layouts.admin.app', ['title' => 'Edit Penjualan'])

@section('content')
    <div class="section-header">
        <h1>Edit Penjualan</h1>
    </div>
    <hr />
    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Customer</label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                    <option value="">Pilih Customer</option>
                    @foreach ($data_customer as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $penjualan->customer_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Produk</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <option value="">Pilih Jenis Produk</option>
                    @foreach ($data_product as $item)
                        <option value="{{ $item->id }}" data-satuan="{{ $item->satuan }}"
                            data-hrg-beli-satuan="{{ $item->hrg_beli_satuan }}"
                            @if ($item->id == $penjualan->product_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jumlah Produk</label>
                <input type="text" name="qty" id="qty" class="form-control" placeholder="Jumlah"
                    value="{{ $penjualan->qty }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" id="satuan_produk" class="form-control" placeholder="Satuan"
                    value="{{ $penjualan->product->satuan }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Total Harga</label>
                <input type="text" name="total_belanja" class="form-control" placeholder="Total Harga"
                    value="{{ $penjualan->total_belanja }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Pilih Jenis Pengeluaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $penjualan->metode_pembayaran_id) selected @endif>
                            {{ $item->metode_pembayaran }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Diskon</label>
                <input type="text" name="diskon" class="form-control" placeholder="Diskon"
                    value="{{ $penjualan->diskon }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <label class="form-label">Total Bayar</label>
                <input type="text" name="total_bayar" class="form-control" placeholder="Total Bayar"
                    value="{{ $penjualan->total_bayar }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Pembayaran</label>
                <input type="text" name="pembayaran" class="form-control" placeholder="Pembayaran"
                    value="{{ $penjualan->pembayaran }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Utang</label>
                <input type="text" name="piutang" class="form-control" placeholder="Piutang"
                    value="{{ $penjualan->piutang }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                    value="{{ $penjualan->tanggal }}">
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var productSelect = document.getElementById("product_id");
        var satuanInput = document.getElementById("satuan_produk");
        var hargaBeliSatuanInput = document.getElementById("hrg_beli_satuan");
        var qtyInput = document.getElementById("qty");
        var totalHargaInput = document.getElementById("total_belanja");

        function hitungTotalHarga() {
            var hargaBeliSatuan = parseFloat(hargaBeliSatuanInput.value) || 0;
            var qty = parseFloat(qtyInput.value) || 0;
            var totalHarga = hargaBeliSatuan * qty;
            totalHargaInput.value = totalHarga.toFixed(2);
        }

        productSelect.addEventListener("change", function() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var satuan = selectedOption.getAttribute("data-satuan") || "";
            var hargaBeliSatuan = selectedOption.getAttribute("data-hrg-beli-satuan") || "";
            satuanInput.value = satuan;
            hargaBeliSatuanInput.value = hargaBeliSatuan;
            hitungTotalHarga();
        });

        qtyInput.addEventListener("input", function() {
            hitungTotalHarga();
        });

        // Inisialisasi nilai saat halaman dimuat
        var initialOption = productSelect.options[productSelect.selectedIndex];
        var initialSatuan = initialOption.getAttribute("data-satuan") || "";
        var initialHargaBeliSatuan = initialOption.getAttribute("data-hrg-beli-satuan") || "";
        satuanInput.value = initialSatuan;
        hargaBeliSatuanInput.value = initialHargaBeliSatuan;
        hitungTotalHarga();
    });

    document.addEventListener("DOMContentLoaded", function() {
        var totalBelanjaInput = document.getElementById("total_belanja");
        var diskonInput = document.getElementById("diskon");
        var totalBayarInput = document.getElementById("total_bayar");

        totalBelanjaInput.addEventListener("input", calculateTotalBayar);
        diskonInput.addEventListener("input", calculateTotalBayar);

        function calculateTotalBayar() {
            var totalBelanja = parseFloat(totalBelanjaInput.value) || 0;
            var diskon = parseFloat(diskonInput.value) || 0;
            var totalBayar = totalBelanja - diskon;
            totalBayarInput.value = totalBayar.toFixed(2);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        var totalBayarInput = document.getElementById("total_bayar");
        var pembayaranInput = document.getElementById("pembayaran");
        var utangInput = document.getElementById("piutang");

        totalBayarInput.addEventListener("input", calculateUtang);
        pembayaranInput.addEventListener("input", calculateUtang);

        function calculateUtang() {
            var totalBayar = parseFloat(totalBayarInput.value) || 0;
            var pembayaran = parseFloat(pembayaranInput.value) || 0;
            var utang = Math.max(0, totalBayar - pembayaran); // Menghindari nilai negatif
            utangInput.value = utang.toFixed(2);
        }
    });
</script>
