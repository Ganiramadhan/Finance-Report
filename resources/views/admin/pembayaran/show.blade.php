@extends('layouts.admin.app', ['title' => 'Detail Pembayaran'])

@section('content')
    <div class="section-header">
        <h1>Detail Pembayaran</h1>
    </div>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Jenis Pengeluaran</label>
            <input type="text" name="nama" class="form-control" placeholder="Jenis Pengeluaran"
                value="{{ $pembayaran->kategori_pengeluaran->nama_kategori }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Jumlah</label>
            <input type="text" name="penerima" class="form-control" placeholder="Penerima"
                value="{{ $pembayaran->penerima }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="keterangan"
                value="{{ $pembayaran->keterangan }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Jumlah Pembayaran</label>
            <input type="text" name="jml_pembayaran" class="form-control" placeholder="Harga"
                value="{{ 'Rp ' . number_format($pembayaran->jml_pembayaran, 0, ',', '.') }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <input type="text" name="no_telepon" class="form-control" placeholder="Nomor Telepon"
                value="{{ $pembayaran->metode_pembayaran->metode_pembayaran }}" readonly>
        </div>

    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                value="{{ $pembayaran->tanggal }}" readonly>
        </div>

    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At"
                value="{{ $pembayaran->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At"
                value="{{ $pembayaran->updated_at }}" readonly>
        </div>
    </div>
@endsection
