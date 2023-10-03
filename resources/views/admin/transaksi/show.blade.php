@extends('layouts.admin.app', ['title' => 'Detail Transaksi'])

@section('content')
    <div class="section-header">
        <h1>Detail Transaksi</h1>
    </div>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Kode Transaksi</label>
            <input type="text" name="penerima" class="form-control" placeholder="Penerima"
                value="{{ $transaksi->kd_transaksi }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Jenis Transaksi</label>
            <input type="text" name="nama" class="form-control" placeholder="Jenis Pengeluaran"
                value="{{ $transaksi->jenis_transaksi->jenis_transaksi }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="keterangan"
                value="{{ $transaksi->keterangan }}" readonly>
        </div>

        <div class="col mb-3">
            <label class="form-label">Jumlah</label>
            <input type="text" name="jumlah" class="form-control" placeholder="Nomor Telepon"
                value="{{ 'Rp ' . number_format($transaksi->jumlah, 0, ',', '.') }}" readonly>
        </div>
    </div>
    <div class="row">


    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                value="{{ $transaksi->tanggal }}" readonly>
        </div>

    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At"
                value="{{ $transaksi->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At"
                value="{{ $transaksi->updated_at }}" readonly>
        </div>
    </div>
@endsection
