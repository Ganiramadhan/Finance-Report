@extends('layouts.admin.app', ['title' => 'Edit Pembelian'])

@section('content')
    <div class="section-header">
        <h1> Edit Pembelian</h1>
    </div>
    <hr />
    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="kd_transaksi" class="form-control" placeholder="Kode Transaksi"
                    value="{{ $pembelian->kd_transaksi }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Produk</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <option value="">Pilih Jenis Produk</option>
                    @foreach ($data_product as $item)
                        <option value="{{ $item->id }}" data-harga-beli-satuan="{{ $item->hrg_beli_satuan }}"
                            data-satuan="{{ $item->satuan }}" @if ($item->id == $pembelian->product_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" id="satuan_produk" class="form-control" placeholder="Satuan" readonly
                    value="{{ $pembelian->product->satuan }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Jumlah Produk</label>
                <input type="text" name="qty" id="qty" class="form-control" placeholder="Jumlah"
                    value="{{ $pembelian->qty }}" readonly>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Total Harga</label>
                <input type="text" name="total_harga" class="form-control" placeholder="Total Harga"
                    value="{{ $pembelian->total_harga }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Pilih Jenis Pengeluaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $pembelian->metode_pembayaran_id) selected @endif>
                            {{ $item->metode_pembayaran }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Supplier</label>
                <select class="form-control" id="supplier_id" name="supplier_id" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($data_supplier as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $pembelian->supplier_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <label class="form-label">Total Belanja</label>
                <input type="text" name="total_belanja" class="form-control" placeholder="Total Belanja"
                    value="{{ $pembelian->total_belanja }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Diskon</label>
                <input type="text" name="diskon" class="form-control" placeholder="Diskon"
                    value="{{ $pembelian->diskon }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Total Bayar</label>
                <input type="text" name="total_bayar" class="form-control" placeholder="Total Bayar"
                    value="{{ $pembelian->total_bayar }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Pembayaran</label>
                <input type="text" name="pembayaran" class="form-control" placeholder="Pembayaran"
                    value="{{ $pembelian->pembayaran }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Utang</label>
                <input type="text" name="utang" class="form-control" placeholder="Utang"
                    value="{{ $pembelian->utang }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                    value="{{ $pembelian->tanggal }}">
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

        productSelect.addEventListener("change", function() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var satuan = selectedOption.getAttribute("data-satuan") || "";
            satuanInput.value = satuan;
        });

        // Inisialisasi nilai Satuan saat halaman dimuat
        var initialOption = productSelect.options[productSelect.selectedIndex];
        var initialSatuan = initialOption.getAttribute("data-satuan") || "";
        satuanInput.value = initialSatuan;
    });



    document.addEventListener("DOMContentLoaded", function() {
        var productSelect = document.getElementById("product_id");
        var hargaBeliSatuanInput = document.getElementById("hrg_beli_satuan");
        var qtyInput = document.getElementById("qty");
        var totalHargaInput = document.getElementById("total_harga");

        function hitungTotalHarga() {
            var hargaBeliSatuan = parseFloat(hargaBeliSatuanInput.value) || 0;
            var qty = parseFloat(qtyInput.value) || 0;
            var totalHarga = hargaBeliSatuan * qty;
            totalHargaInput.value = totalHarga.toFixed(2);
        }

        // Event listener untuk perubahan pada "Jenis Produk"
        productSelect.addEventListener("change", function() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var hargaBeliSatuan = parseFloat(selectedOption.getAttribute("data-harga-beli-satuan")) ||
                0;
            hargaBeliSatuanInput.value = hargaBeliSatuan.toFixed(2);
            hitungTotalHarga();
        });

        // Event listener untuk perubahan pada "Jumlah Produk"
        qtyInput.addEventListener("input", function() {
            hitungTotalHarga();
        });

        // Inisialisasi nilai Total Harga saat halaman dimuat
        hitungTotalHarga();
    });
</script>
