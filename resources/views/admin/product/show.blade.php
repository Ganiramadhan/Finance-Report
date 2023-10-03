@extends('layouts.admin.app', ['title' => 'Detail Produk'])

@section('content')
    <div class="section-header">
        <h1>Detail Produk</h1>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ $product->nama }}" readonly>
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" class="form-control" value="{{ $product->satuan }}" readonly>
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Jumlah Produk</label>
            <input type="text" name="qty" class="form-control" value="{{ $product->qty }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Harga Beli</label>
            <input type="text" name="hrg_beli" class="form-control"
                value="{{ 'Rp ' . number_format($product->hrg_beli, 0, ',', '.') }}" readonly>
        </div>

    </div>
    <div class="row">


    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Harga Jual</label>
            <input type="text" name="hrg_jual" class="form-control"
                value="{{ 'Rp ' . number_format($product->hrg_jual, 0, ',', '.') }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Total Harga</label>
            <input type="text" class="form-control" value="{{ 'Rp ' . number_format($product->total, 0, ',', '.') }}"
                readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" value="{{ $product->created_at }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" value="{{ $product->updated_at }}" readonly>
        </div>
    </div>
@endsection
