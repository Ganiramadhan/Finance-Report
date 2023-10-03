@extends('layouts.admin.app', ['title' => 'Tambah Pembayaran'])

@section('content')
    <div class="section-header">
        <h1> Tambah Pembayaran</h1>
    </div>
    <hr />
    {{-- 
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    @if ($errors->has('kd_pembayaran'))
        <div class="alert alert-danger">
            Kode Pembayaran sudah digunakan.
        </div>
    @endif

    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="kd_pembayaran" id="kd_pembayaran" class="form-control" placeholder="Kode Pembayaran"
                    required value="{{ old('kd_pembayaran') }}">
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="form-control" id="kategori_pengeluaran_id" name="kategori_pengeluaran_id" required>
                        <option value="">Jenis Pengeluaran</option>
                        @foreach ($data_kategori_pengeluaran as $item)
                            <option value="{{ $item->id }}"
                                {{ old('kategori_pengeluaran_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <input type="text" name="penerima" id="penerima" class="form-control" placeholder="Penerima" required
                    value="{{ old('penerima') }}">
            </div>

            <div class="col">
                <input type="string" name="jml_pembayaran" id="jml_pembayaran" class="form-control"
                    placeholder="Jumlah Pembayaran" required value="{{ old('jml_pembayaran') }}">
            </div>

            <div class="col">
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
        <div class="row mb-3">
            <div class="col-8">
                <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"
                    required value="{{ old('keterangan') }}">
            </div>
            <div class="col">
                <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                    required value="{{ old('tanggal') }}">
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

    <script>
        // Fungsi untuk mengisi otomatis "Kode Pembayaran" dengan "TPK"
        function setKodePembayaran() {
            document.getElementById('kd_pembayaran').value = 'TPK-';
        }

        // Panggil fungsi setKodePembayaran saat halaman dimuat
        window.onload = setKodePembayaran;
    </script>
@endsection
