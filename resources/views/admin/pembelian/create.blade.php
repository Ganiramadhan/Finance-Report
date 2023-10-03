@extends('layouts.admin.app', ['title' => 'Tambah Pembelian'])

@section('content')
    <div class="section-header">
        <h1>Tambah Pembelian</h1>
    </div>
    <hr />

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Kode Transaksi</label>
                    <input type="text" name="kd_transaksi" id="kd_transaksi" class="form-control"
                        placeholder="Kode Transaksi" required value="{{ old('kd_transaksi') }}">

                    @error('kd_transaksi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select class="form-control" id="supplier_id" name="supplier_id" required>
                        <option value="">Supplier</option>
                        @foreach ($data_supplier as $item)
                            <option value="{{ $item->id }}" data-saldo-awal-utang="{{ $item->saldo_awal_utang }}"
                                {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Produk</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="">Pilih Jenis Produk</option>
                        @foreach ($data_product as $item)
                            <option value="{{ $item->id }}" data-satuan="{{ $item->satuan }}"
                                data-harga-jual="{{ $item->harga_jual }}" data-harga-beli="{{ $item->hrg_beli }}"
                                {{ old('product_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    {{-- <label class="form-label">Harga Jual Produk</label> --}}
                    <input type="hidden" name="hrg_jual_satuan" id="hrg_jual_satuan" class="form-control"
                        placeholder="Harga Produk" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Produk</label>
                    <input type="number" name="hrg_beli_satuan" id="hrg_beli_satuan" class="form-control"
                        placeholder="Harga Produk" required>
                </div>

                {{-- <input type="hidden" name="hrg_beli_satuan" id="hrg_beli_satuan" class="form-control"
                    placeholder="Harga Beli Satuan" required readonly value="{{ old('hrg_beli_satuan') }}"> --}}

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Jumlah" required
                        value="{{ old('qty') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Satuan" readonly
                        value="{{ old('satuan') }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" name="total_harga" id="total_harga" class="form-control" placeholder="Total Harga"
                        readonly value="{{ old('hrg_jual') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                        <option value="">Metode Pembayaran</option>
                        @foreach ($data_metode_pembayaran as $item)
                            <option value="{{ $item->id }}"
                                {{ old('metode_pembayaran_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->metode_pembayaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <input type="hidden" name="saldo_awal_utang" id="saldo_awal_utang" value="{{ old('saldo_awal_utang') }}">

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Total Belanja</label>
                    <input type="number" name="total_belanja" id="total_belanja" class="form-control"
                        placeholder="Total Belanja" required value="{{ old('total_belanja') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Diskon</label>
                    <input type="number" name="diskon" id="diskon" class="form-control" placeholder="Diskon" required
                        value="{{ old('diskon') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Bayar</label>
                    <input type="number" name="total_bayar" id="total_bayar" class="form-control"
                        placeholder="Total Bayar" required value="{{ old('total_bayar') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pembayaran</label>
                    <input type="number" name="pembayaran" id="pembayaran" class="form-control"
                        placeholder="Pembayaran" required value="{{ old('pembayaran') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Utang</label>
                    <input type="string" name="utang" id="utang" class="form-control" placeholder="Utang"
                        required value="{{ old('utang') }}">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                        placeholder="Keterangan" required value="{{ old('keterangan') }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        placeholder="Tanggal Transaksi" required value="{{ old('tanggal') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="d-grid">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection



<script>
    function setKodePembelian() {
        document.getElementById('kd_transaksi').value = 'TPP-';
    }

    // Panggil fungsi setKodePembelian saat halaman dimuat
    window.onload = setKodePembelian;

    document.addEventListener("DOMContentLoaded", function() {
        var productSelect = document.getElementById("product_id");
        var satuanInput = document.getElementById("satuan");
        var qtyInput = document.getElementById("qty");
        var totalHargaInput = document.getElementById("total_harga");
        var totalBelanjaInput = document.getElementById("total_belanja");
        var diskonInput = document.getElementById("diskon");
        var totalBayarInput = document.getElementById("total_bayar");
        var supplierSelect = document.getElementById("supplier_id");
        var utangInput = document.getElementById("utang");
        var saldoAwalUtangInput = document.getElementById("saldo_awal_utang");
        var hargaJualSatuanInput = document.getElementById("hrg_jual_satuan");
        var hargaBeliSatuanInput = document.getElementById("hrg_beli_satuan");

        // Function untuk mengupdate "Satuan" berdasarkan produk yang dipilih
        function updateSatuan() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var satuan = selectedOption.getAttribute("data-satuan") || "";
            satuanInput.value = satuan;
        }

        // Function untuk mengisi harga jual dan harga beli berdasarkan jenis produk yang dipilih
        function updateHargaJualHargaBeli() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var hargaJual = parseFloat(selectedOption.getAttribute("data-harga-jual")) || 0;
            var hargaBeli = parseFloat(selectedOption.getAttribute("data-harga-beli")) || 0;

            // Isi input harga jual dan harga beli
            hargaJualSatuanInput.value = hargaJual.toFixed(2);
            hargaBeliSatuanInput.value = hargaBeli.toFixed(2);

            calculateTotalHarga();
            calculateTotalBayar();
        }

        // Event listener untuk perubahan produk yang dipilih
        productSelect.addEventListener("change", function() {
            updateSatuan();
            updateHargaJualHargaBeli();
        });

        // Event listener untuk perubahan jumlah yang diinputkan
        qtyInput.addEventListener("input", function() {
            calculateTotalHarga();
            calculateUtang(); // Perubahan utang saat jumlah produk diubah
        });

        // Function untuk menghitung total harga
        function calculateTotalHarga() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var selectedHarga = parseFloat(hargaBeliSatuanInput.value) ||
                0; // Menggunakan harga beli sebagai acuan
            var jumlah = parseFloat(qtyInput.value) || 0;
            var totalHarga = selectedHarga * jumlah;
            totalHargaInput.value = totalHarga.toFixed(2);
            totalBelanjaInput.value = totalHarga.toFixed(2);
            calculateTotalBayar();
        }

        // Event listener untuk perubahan diskon
        diskonInput.addEventListener("input", function() {
            calculateTotalBayar();
            calculateUtang(); // Perubahan utang saat diskon diubah
        });

        // Function untuk menghitung total bayar
        function calculateTotalBayar() {
            var totalBelanja = parseFloat(totalBelanjaInput.value) || 0;
            var diskon = parseFloat(diskonInput.value) || 0;
            var totalBayar = Math.max(0, totalBelanja - diskon); // Total bayar tidak pernah negatif
            totalBayarInput.value = totalBayar.toFixed(2);
        }

        // Event listener untuk perubahan supplier yang dipilih
        supplierSelect.addEventListener("change", function() {
            updateSaldoAwalUtang();
            calculateUtang(); // Perubahan utang saat supplier diubah
        });

        // Function untuk mengupdate saldo awal utang berdasarkan supplier yang dipilih
        function updateSaldoAwalUtang() {
            var selectedSupplierOption = supplierSelect.options[supplierSelect.selectedIndex];
            var saldoAwalUtang = parseFloat(selectedSupplierOption.getAttribute("data-saldo-awal-utang")) || 0;
            saldoAwalUtangInput.value = saldoAwalUtang.toFixed(2);
        }

        // Function untuk menghitung utang
        function calculateUtang() {
            var totalBayar = parseFloat(totalBayarInput.value) || 0;
            var pembayaran = parseFloat(document.getElementById("pembayaran").value) || 0;
            var saldoAwal = parseFloat(saldoAwalUtangInput.value) || 0;
            var utang = saldoAwal + totalBayar - pembayaran;
            utang = utang < 0 ? 0 : utang; // Utang tidak pernah negatif
            utangInput.value = utang.toFixed(2);
        }

        // Event listener untuk perubahan pembayaran
        var pembayaranInput = document.getElementById("pembayaran");
        pembayaranInput.addEventListener("input", function() {
            calculateUtang();
        });

        // Perhitungan awal saat halaman dimuat
        updateSatuan();
        updateHargaJualHargaBeli();
        calculateTotalHarga();
        calculateTotalBayar();
        updateSaldoAwalUtang();
        calculateUtang();
    });
</script>
