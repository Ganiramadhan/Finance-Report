@extends('layouts.admin.app', ['title' => 'Edit Pembayaran'])

@section('content')
    <div class="section-header">
        <h1> Edit Pembayaran</h1>
    </div>
    <hr />
    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col mb-3">
                <label class="form-label">Kode Pembayaran</label>
                <input type="text" name="kd_pembayaran" class="form-control" placeholder="Kode Pembayaran" id="kd_pembayaran"
                    value="{{ $pembayaran->kd_pembayaran }}" required readonly>
            </div>

            <div class="col mb-3">
                <label class="form-label">Jenis Pengeluaran</label>
                <select class="form-control" id="kategori_pengeluaran_id" name="kategori_pengeluaran_id" required>
                    <option value="">Pilih Jenis Pengeluaran</option>
                    @foreach ($data_kategori_pengeluaran as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $pembayaran->kategori_pengeluaran_id) selected @endif>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="col mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="keterangan" id="keterangan"
                    value="{{ $pembayaran->keterangan }}" required>
            </div>


            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Penerima</label>
                    <input type="text" name="penerima" class="form-control" placeholder="penerima" id="penerima"
                        value="{{ $pembayaran->penerima }}"required>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                        <option value="">Metode Pembayaran</option>
                        @foreach ($data_metode_pembayaran as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $pembayaran->metode_pembayaran_id) selected @endif>
                                {{ $item->metode_pembayaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col mb-3">
                    <label class="form-label">Jumlah Pembayaran</label>
                    <input type="text" name="jml_pembayaran" class="form-control" placeholder="jml_pembayaran"
                        id="jml_pembayaran" value="{{ $pembayaran->jml_pembayaran }}" required>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal" class="form-control" placeholder="tanggal" id="tanggal"
                        value="{{ $pembayaran->tanggal }}" required>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
@endsection

<script>
    $(document).ready(function() {
        // Inisialisasi elemen select sebagai Select2
        $('#kategori_pengeluaran_id').select2();
    });

    // Saat dokumen telah dimuat
    document.addEventListener('DOMContentLoaded', function() {
        var productSelect = document.getElementById('product_id');
        var hargaInput = document.getElementById('hrg_jual');

        // Fungsi untuk mengatur harga berdasarkan pilihan produk
        function setHarga() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var harga = selectedOption.getAttribute('data-hrg-jual');
            hargaInput.value = harga;
        }

        // Panggil fungsi setHarga saat dokumen dimuat dan saat pilihan produk berubah
        setHarga();
        productSelect.addEventListener('change', setHarga);
    });


    // Saat dokumen telah dimuat
    document.addEventListener('DOMContentLoaded', function() {
        var productSelect = document.getElementById('product_id');
        var hargaInput = document.getElementById('hrg_jual');
        var jumlahInput = document.getElementById('jumlah');
        var totalHargaInput = document.getElementById('total');

        // Fungsi untuk menghitung total harga berdasarkan harga dan jumlah
        function hitungTotalHarga() {
            var harga = parseFloat(hargaInput.value);
            var jumlah = parseInt(jumlahInput.value);
            var totalHarga = harga * jumlah;
            totalHargaInput.value = totalHarga.toFixed(2); // Mengatur jumlah desimal
        }

        // Panggil fungsi hitungTotalHarga saat dokumen dimuat dan saat input harga atau jumlah berubah
        setHarga();
        hitungTotalHarga();
        productSelect.addEventListener('change', function() {
            setHarga();
            hitungTotalHarga();
        });
        jumlahInput.addEventListener('input', hitungTotalHarga);
    });
</script>
