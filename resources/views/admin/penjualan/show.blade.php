@extends('layouts.admin.app', ['title' => 'Detail Penjualan'])

@section('content')
    <div class="section-header">
        <h1>Detail Penjualan</h1>
    </div>
    <hr />

    <form>
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text" class="form-control" placeholder="Customer" value="{{ $penjualan->customer->nama }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Jenis Produk</label>
                    <input type="text" class="form-control" placeholder="Jenis Produk"
                        value="{{ $penjualan->product->nama }}" readonly>
                </div>

            </div>
            <div class="col-md-2">
                <label class="form-label">Harga Produk</label>
                <input type="text" class="form-control" placeholder="Total Harga"
                    value="{{ 'Rp ' . number_format($penjualan->hrg_jual_satuan, 0, ',', '.') }}" readonly>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" class="form-control" placeholder="Satuan"
                        value="{{ $penjualan->product->satuan }}" readonly>
                </div>
            </div>

        </div>

        <div class="row mb-3">

            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Jumlah Produk</label>
                    <input type="text" class="form-control" placeholder="Jumlah" value="{{ $penjualan->qty }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" class="form-control" placeholder="Total Harga"
                        value="{{ 'Rp ' . number_format($penjualan->total_belanja, 0, ',', '.') }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Diskon</label>
                    <input type="text" class="form-control" placeholder="Diskon"
                        value="{{ 'Rp ' . number_format($penjualan->diskon, 0, ',', '.') }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Total Bayar</label>
                    <input type="text" class="form-control" placeholder="Total Bayar"
                        value="{{ 'Rp ' . number_format($penjualan->total_bayar, 0, ',', '.') }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Pembayaran</label>
                    <input type="text" class="form-control" placeholder="Pembayaran"
                        value="{{ 'Rp ' . number_format($penjualan->pembayaran, 0, ',', '.') }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Sisa Utang</label>
                    <input type="text" class="form-control" placeholder="Utang"
                        value="{{ 'Rp ' . number_format($penjualan->piutang, 0, ',', '.') }}" readonly>
                </div>
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <input type="text" class="form-control" placeholder="Metode Pembayaran"
                        value="{{ $penjualan->metode_pembayaran->metode_pembayaran }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="text" class="form-control" placeholder="Tanggal Transaksi"
                        value="{{ $penjualan->tanggal }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Created At</label>
                    <input type="text" class="form-control" placeholder="Created At"
                        value="{{ $penjualan->created_at }}" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Updated At</label>
                    <input type="text" class="form-control" placeholder="Updated At"
                        value="{{ $penjualan->updated_at }}" readonly>
                </div>
            </div>
        </div>


    </form>
@endsection
