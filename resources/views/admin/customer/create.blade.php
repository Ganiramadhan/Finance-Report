@extends('layouts.admin.app', ['title' => 'Tambah Customer'])

@section('content')
    <div class="section-header">
        <h1>Tambah Customer</h1>
    </div>
    <hr />

    <form action="{{ route('customer.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer">Nama Customer</label>
                    <input type="text" name="nama" class="form-control" id="customer" placeholder="Nama Customer"
                        required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="saldo_awal_piutang">Jumlah Piutang</label>
                    <input type="number" name="saldo_awal_piutang" class="form-control" id="saldo_awal_piutang"
                        placeholder="Masukkan Jumlah Piutang" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input type="number" name="no_telepon" class="form-control" id="no_telepon"
                        placeholder="Masukkan Nomor Telepon" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat Customer" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
