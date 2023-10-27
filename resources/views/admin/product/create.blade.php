@extends('layouts.admin.app', ['title' => 'Tambah Produk'])

@section('content')
    <style>
        /* Menambahkan warna latar belakang merah ke pesan kesalahan */
        /* Mengubah warna latar belakang pesan kesalahan Alertify menjadi merah */
        .ajs-modal.ajs-error-background {
            color: red;
            font-size: 15px;
            font-style: italic
        }
    </style>
    <div class="section-header">
        <h1>Tambah Produk</h1>
    </div>
    <hr />

    <form action="{{ route('product.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required
                    value="{{ old('nama') }}">
            </div>

            <div class="col">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="hrg_beli" class="form-control" placeholder="Harga Beli" required
                    value="{{ old('hrg_beli') }}" id="hrg_beli">
            </div>
            <div class="col">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-select" required>
                    <option value="">Pilih Satuan</option>
                    <option value="unit" {{ old('satuan') === 'unit' ? 'selected' : '' }}>Unit</option>
                    <option value="pcs" {{ old('satuan') === 'pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="box" {{ old('satuan') === 'box' ? 'selected' : '' }}>Box</option>
                    <option value="liter" {{ old('satuan') === 'liter' ? 'selected' : '' }}>Liter</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" placeholder="Harga Jual" id="harga_jual"
                    required value="{{ old('harga_jual') }}">
            </div>
            <div class="col">
                <label class="form-label">Jumlah Produk</label>
                <input type="number" name="qty" class="form-control" placeholder="Jumlah Produk" id="qty"
                    required value="{{ old('qty') }}">
            </div>

            <div class="col">
                <label class="form-label">Total Bayar</label>
                <input type="text" name="total" class="form-control" placeholder="Total Harga" id="total" readonly
                    value="{{ old('total') }}">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var qtyInput = document.getElementById("qty");
            var hargaBeliInput = document.getElementById("hrg_beli");
            var totalInput = document.getElementById("total");

            qtyInput.addEventListener("input", updateTotal);
            hargaBeliInput.addEventListener("input", updateTotal);

            function updateTotal() {
                var qty = parseFloat(qtyInput.value) || 0;
                var hargaBeli = parseFloat(hargaBeliInput.value) || 0;
                var total = qty * hargaBeli;
                totalInput.value = total.toFixed(2);
            }
        });



        $(document).ready(function() {
            // Cek apakah ada pesan kesalahan dalam variabel JavaScript
            var errorMessage = "{{ $errors->first('nama') }}";

            if (errorMessage) {
                // Tampilkan pesan kesalahan menggunakan Alertify dengan warna merah
                alertify.alert('Error', errorMessage).setHeader('Message').set('basic', true).set('modal', true);
                // Menambahkan kelas CSS untuk warna merah pada latar belakang
                $(".ajs-modal").addClass("ajs-error-background");
            }
        });
    </script>
@endsection
