@extends('layouts.admin.app', ['title' => 'Tambah Transaksi'])

@section('content')
    <div class="section-header">
        <h1>Data Transaksi Transaksi</h1>
    </div>
    <hr />
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="row mb-3">

            <div class="mb-3">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="kd_transaksi" id="kd_transaksi" class="form-control" placeholder="Kode Transaksi"
                    required value="{{ old('kd_transaksi') }}">

                @error('kd_transaksi')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <select class="form-control" id="jenis_transaksi_id" name="jenis_transaksi_id" required>
                    <option value="">Jenis Transaksi</option>
                    @foreach ($data_jenis_transaksi as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis_transaksi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Metode Pembayaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}">{{ $item->metode_pembayaran }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"
                    required value="{{ old('keterangan') }}">
            </div>

            <div class="col">
                <input type="string" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Transaksi"
                    required value="{{ old('jumlah') }}">
            </div>

        </div>
        <div class="row mb-3">

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
        // Fungsi untuk mengisi otomatis "Kode Transaksi" dengan "TKL"
        function setKodeTransaksi() {
            document.getElementById('kd_transaksi').value = 'TKL-';
        }

        // Panggil fungsi setKodeTransaksi saat halaman dimuat
        window.onload = setKodeTransaksi;
    </script>
@endsection
