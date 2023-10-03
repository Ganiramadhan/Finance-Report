@extends('layouts.admin.app', ['title' => 'Detail Pembelian'])

@section('content')
    <div class="section-header">
        <h1> Detail Pembelian</h1>
    </div>
    <hr />

    <div class="row mb-3">
        <div class="col-md-2">
            <label class="form-label">Kode Transaksi</label>
            <input type="text" name="nama" class="form-control" placeholder="Kode Transaksi"
                value="{{ $pembelian->kd_transaksi }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jenis Produk</label>
            <input type="text" name="penerima" class="form-control" placeholder="Jenis Produk"
                value="{{ $pembelian->product->nama }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Harga Produk</label>
            <input type="text" name="hrg_beli_satuan" class="form-control" placeholder="Harga Produk"
                value="{{ $pembelian->hrg_beli_satuan }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Jumlah Produk</label>
            <input type="text" name="qty" class="form-control" placeholder="Jumlah" value="{{ $pembelian->qty }}"
                readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Satuan</label>
            <input type="text" name="satuan" class="form-control" placeholder="Satuan"
                value="{{ $pembelian->product->satuan }}" readonly>
        </div>

    </div>


    <div class="row mb-3">
        <div class="col-md-2">
            <label class="form-label">Total Harga</label>
            <input type="text" name="total_harga" class="form-control" placeholder="Total Harga"
                value="{{ $pembelian->total_harga }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Total Belanja</label>
            <input type="text" name="created_at" class="form-control" placeholder="Total Belanja"
                value="{{ 'Rp ' . number_format($pembelian->total_belanja, 0, ',', '.') }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Diskon</label>
            <input type="text" name="diskon" class="form-control" placeholder="Diskon"
                value="{{ 'Rp ' . number_format($pembelian->diskon, 0, ',', '.') }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Total Bayar</label>
            <input type="text" name="total_bayar" class="form-control" placeholder="Total Bayar"
                value="{{ 'Rp ' . number_format($pembelian->total_bayar, 0, ',', '.') }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Pembayaran</label>
            <input type="text" name="Pembayaran" class="form-control" placeholder="Pembayaran"
                value="{{ 'Rp ' . number_format($pembelian->pembayaran, 0, ',', '.') }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Utang</label>
            <input type="text" name="utang" class="form-control" placeholder="Utang"
                value="{{ 'Rp ' . number_format($pembelian->utang, 0, ',', '.') }}" readonly>
        </div>

    </div>
    <div class="row mb-3">

        <div class="col-md-2">
            <label class="form-label">Metode Pembayaran</label>
            <input type="text" name="tanggal" class="form-control" placeholder="Metode Pembayaran"
                value="{{ $pembelian->metode_pembayaran->metode_pembayaran }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" placeholder="Supplier"
                value="{{ $pembelian->supplier->nama }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="text" name="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                value="{{ $pembelian->tanggal }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Created At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Created At"
                value="{{ $pembelian->created_at }}" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At"
                value="{{ $pembelian->updated_at }}" readonly>
        </div>
    </div>
@endsection
