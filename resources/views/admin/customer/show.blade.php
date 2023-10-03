@extends('layouts.admin.app', ['title' => 'Detail Customer'])

@section('content')
    <div class="section-header">
        <h1>Detail Customer</h1>
    </div>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ $customer->nama }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Jumlah Piutang</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama"
                value="{{ 'Rp ' . number_format($customer->saldo_awal_piutang, 0, ',', '.') }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="no_telepon" class="form-control" placeholder="Alamat"
                value="{{ $customer->no_telepon }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" placeholder="Nomor Telepon"
                value="{{ $customer->alamat }}" readonly>
        </div>

    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At"
                value="{{ $customer->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At"
                value="{{ $customer->updated_at }}" readonly>
        </div>
    </div>
@endsection
