@extends('layouts.admin.app', ['title' => 'Edit Transaksi'])

@section('content')
    <div class="section-header">
        <h1>Edit Transaksi</h1>
    </div>
    <hr />
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col mb-3">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="kd_transaksi" class="form-control" placeholder="Kode Transaksi" id="kd_transaksi"
                    value="{{ $transaksi->kd_transaksi }}" required readonly>
            </div>
            <div class="col mb-3">
                <label class="form-label">Jenis Pengeluaran</label>
                <select class="form-control" id="jenis_transaksi_id" name="jenis_transaksi_id" required>
                    <option value="">Pilih Jenis Transaksi</option>
                    @foreach ($data_jenis_transaksi as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $transaksi->jenis_transaksi_id) selected @endif>
                            {{ $item->jenis_transaksi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Metode Pembayaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $transaksi->metode_pembayaran_id) selected @endif>
                            {{ $item->metode_pembayaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="keterangan" id="keterangan"
                    value="{{ $transaksi->keterangan }}" required>
            </div>


            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="jumlah" id="jumlah"
                        value="{{ $transaksi->jumlah }}"required>
                </div>

                <div class="col mb-3">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal" class="form-control" placeholder="tanggal" id="tanggal"
                        value="{{ $transaksi->tanggal }}" required>
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
