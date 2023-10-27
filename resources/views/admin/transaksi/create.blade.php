@extends('layouts.admin.app', ['title' => 'Tambah Transaksi'])

@section('content')
    <style>
        .ajs-modal.ajs-error-background {
            color: red;
            font-size: 15px;
            font-style: italic;
        }
    </style>
    <div class="section-header">
        <h1>Data Transaksi Transaksi</h1>
    </div>
    <hr />

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="mb-3">
                <label for="kd_transaksi" class="form-label">Kode Transaksi</label>
                <input type="text" name="kd_transaksi" id="kd_transaksi" class="form-control" placeholder="Kode Transaksi"
                    required value="{{ old('kd_transaksi') }}">
                @error('kd_transaksi')
                    <script>
                        $(document).ready(function() {
                            var errorMessage = "{{ $message }}";
                            if (errorMessage) {
                                alertify.alert('Error', errorMessage).setHeader('Validation Error').set('basic', true).set('modal',
                                    true);
                                $(".ajs-header").addClass("ajs-error-background"),
                                    $(".ajs-modal").addClass("ajs-error-background");
                            }
                        });
                    </script>
                @enderror
            </div>
            <div class="col">
                <label for="jenis_transaksi_id" class="form-label">Jenis Transaksi</label>
                <select class="form-control" id="jenis_transaksi_id" name="jenis_transaksi_id" required>
                    <option value="">Jenis Transaksi</option>
                    @foreach ($data_jenis_transaksi as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis_transaksi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="metode_pembayaran_id" class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Metode Pembayaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}">{{ $item->metode_pembayaran }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"
                    required value="{{ old('keterangan') }}">
            </div>
            <div class="col">
                <label for="jumlah" class="form-label">Jumlah Transaksi</label>
                <input type="string" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Transaksi"
                    required value="{{ old('jumlah') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="tanggal" class="form-label">Tanggal Transaksi</label>
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
        function setKodeTransaksi() {
            document.getElementById('kd_transaksi').value = 'TKL-';
        }
        window.onload = setKodeTransaksi;
    </script>
@endsection
