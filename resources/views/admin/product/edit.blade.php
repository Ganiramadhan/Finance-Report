@extends('layouts.admin.app', ['title' => 'Edit Produk'])

@section('content')
    <div class="section-header">
        <h1>Edit Produk</h1>
    </div>
    <hr />

    <form action="{{ route('product.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Produk"
                    value="{{ old('nama', $product->nama) }}" required>
                @error('nama')
                    <div class="alert alert-danger mt-2">{{ $message }} </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-select" required>
                    <option value="unit" @if ($product->satuan == 'unit') selected @endif>Unit</option>
                    <option value="pcs" @if ($product->satuan == 'pcs') selected @endif>Pcs</option>
                    <option value="box" @if ($product->satuan == 'box') selected @endif>Box</option>
                    <option value="liter" @if ($product->satuan == 'liter') selected @endif>Liter</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Produk</label>
                <input type="number" name="qty" id="qty" class="form-control" placeholder="Jumlah Produk"
                    value="{{ $product->qty }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="hrg_beli" id="hrg_beli" class="form-control" placeholder="Harga Beli "
                    value="{{ $product->hrg_beli }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" class="form-control" placeholder="Harga Beli Satuan"
                    value="{{ $product->harga_jual }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Total Harga</label>
                <input type="number" name="total" id="total_produk" class="form-control" placeholder="Total Produk"
                    value="{{ $product->total }}" required readonly>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="d-grid">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen yang dibutuhkan
        var qtyInput = document.getElementById('qty');
        var hargaBeliInput = document.getElementById('hrg_beli');
        var totalInput = document.getElementById('total_produk');

        // Tambahkan event listener ketika qtyInput atau hargaBeliInput berubah
        qtyInput.addEventListener('input', updateTotal);
        hargaBeliInput.addEventListener('input', updateTotal);

        // Fungsi untuk mengupdate total
        function updateTotal() {
            var qty = parseFloat(qtyInput.value) || 0;
            var hargaBeli = parseFloat(hargaBeliInput.value) || 0;
            var total = qty * hargaBeli;
            totalInput.value = total.toFixed(2); // Membulatkan total menjadi dua angka desimal
        }

        // Panggil fungsi updateTotal saat halaman dimuat
        updateTotal();
    });
</script>
