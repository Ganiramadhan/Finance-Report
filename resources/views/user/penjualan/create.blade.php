@extends('layouts.admin.appUser', ['title' => 'Tambah Penjualan'])

@section('content')
    <div class="section-header">
        <h1>Tambah Penjualan</h1>
    </div>
    <hr />
    {{-- @if (session('error'))
        <div class="alert alert-danger">

            {{ session('error') }}
        </div>
    @endif --}}


    <form action="/user/penjualan/store" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                        <option value="">Pilih Customer</option>
                        @foreach ($data_customer as $item)
                            <option value="{{ $item->id }}" data-saldo_awal_piutang="{{ $item->saldo_awal_piutang }}">
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Produk</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="">Pilih Jenis Produk</option>
                        @foreach ($data_product as $item)
                            <option value="{{ $item->id }}" data-harga="{{ $item->harga_jual }}"
                                data-harga-beli="{{ $item->hrg_beli }}" data-satuan="{{ $item->satuan }}">
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="harga_jual" id="harga_jual" class="form-control" placeholder="Harga Jual"
                    required readonly>
                <div class="mb-3">
                    <label class="form-label">Harga Produk</label>
                    <input type="number" name="hrg_jual_satuan" id="hrg_jual_satuan" class="form-control"
                        placeholder="Harga Produk" required>
                </div>
                <div class="mb-3">
                    {{-- <label class="form-label">Harga Beli Produk</label> --}}
                    <input type="hidden" name="hrg_beli_satuan" id="hrg_beli_satuan" class="form-control"
                        placeholder="Harga Produk" required>
                </div>
                <!-- Tambahkan input untuk satuan -->

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Jumlah" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Satuan" readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" name="total_harga" id="total_harga" class="form-control" placeholder="Total Harga"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                        <option value="">Metode Pembayaran</option>
                        @foreach ($data_metode_pembayaran as $item)
                            <option value="{{ $item->id }}">{{ $item->metode_pembayaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Total Belanja</label>
                    <input type="number" name="total_belanja" id="total_belanja" class="form-control"
                        placeholder="Total Belanja" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diskon</label>
                    <input type="number" name="diskon" id="diskon" class="form-control" placeholder="Diskon" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Bayar</label>
                    <input type="number" name="total_bayar" id="total_bayar" class="form-control" placeholder="Total Bayar"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pembayaran</label>
                    <input type="number" name="pembayaran" id="pembayaran" class="form-control" placeholder="Pembayaran"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Piutang</label>
                    <input type="number" name="piutang" id="piutang" class="form-control" placeholder="Piutang"
                        readonly>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        placeholder="Tanggal Transaksi" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Nomor Faktur</label>
                    <input type="text" name="no_faktur" id="no_faktur" class="form-control"
                        placeholder="Nomor Faktur" required>
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var productSelect = document.getElementById("product_id");
            var satuanInput = document.getElementById("satuan");
            var hargaJualInput = document.getElementById("harga_jual");
            var hargaBeliInput = document.getElementById("hrg_beli_satuan");
            var hargaProdukInput = document.getElementById("hrg_jual_satuan"); // Tambahan input harga produk
            var qtyInput = document.getElementById("qty");
            var totalHargaInput = document.getElementById("total_harga");
            var totalBelanjaInput = document.getElementById("total_belanja");
            var diskonInput = document.getElementById("diskon");
            var totalBayarInput = document.getElementById("total_bayar");
            var pembayaranInput = document.getElementById("pembayaran");
            var utangInput = document.getElementById("piutang");
            var saldoAwalPiutang = 0;

            function updateProductFields() {
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                var satuan = selectedOption.getAttribute("data-satuan") || "";
                satuanInput.value = satuan;

                var hargaJual = parseFloat(selectedOption.getAttribute("data-harga")) || 0;
                hargaJualInput.value = hargaJual.toFixed(2);

                var hargaBeli = parseFloat(selectedOption.getAttribute("data-harga-beli")) || 0;
                hargaBeliInput.value = hargaBeli.toFixed(2);

                var hargaProduk = parseFloat(selectedOption.getAttribute("data-harga")) ||
                    0; // Mengambil harga jual produk
                hargaProdukInput.value = hargaProduk.toFixed(2); // Mengisi otomatis harga produk

                calculateTotalHarga();
            }

            productSelect.addEventListener("change", function() {
                updateProductFields();
            });

            qtyInput.addEventListener("input", function() {
                if (pembayaranInput.value === "") {
                    calculateTotalHarga();
                    calculateTotalBelanja();
                }
            });

            diskonInput.addEventListener("input", function() {
                calculateTotalBelanja();
            });

            pembayaranInput.addEventListener("input", function() {
                calculateUtang();
            });

            function calculateTotalHarga() {
                var hargaBeliSatuan = parseFloat(hargaProdukInput.value) || 0; // Menggunakan harga produk
                var qty = parseFloat(qtyInput.value) || 0;
                var totalHarga = hargaBeliSatuan * qty;
                totalHargaInput.value = totalHarga.toFixed(2);
            }

            function calculateTotalBelanja() {
                var totalHarga = parseFloat(totalHargaInput.value) || 0;
                var diskon = parseFloat(diskonInput.value) || 0;
                var totalBelanja = totalHarga - diskon;
                totalBelanjaInput.value = totalBelanja.toFixed(2);
                calculateTotalBayar();
            }

            function calculateTotalBayar() {
                var totalBelanja = parseFloat(totalBelanjaInput.value) || 0;
                totalBayarInput.value = totalBelanja.toFixed(2);
                calculateUtang();
            }

            function calculateUtang() {
                var totalBayar = parseFloat(totalBayarInput.value) || 0;
                var pembayaran = parseFloat(pembayaranInput.value) || 0;
                var utang = totalBayar - pembayaran + saldoAwalPiutang;
                if (utang < 0) {
                    utang = 0;
                }

                utangInput.value = utang.toFixed(2);
            }

            updateProductFields();

            var customerSelect = document.getElementById("customer_id");
            var saldoAwalPiutangInput = document.getElementById("piutang");

            customerSelect.addEventListener("change", function() {
                var selectedOption = customerSelect.options[customerSelect.selectedIndex];
                saldoAwalPiutang = parseFloat(selectedOption.getAttribute("data-saldo_awal_piutang")) || 0;
                calculateUtang();
            });
        });
    </script>
@endsection
