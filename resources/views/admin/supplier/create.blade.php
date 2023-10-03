@extends('layouts.admin.app', ['title' => 'Tambah Supplier'])

@section('content')
    <div class="section-header">
        <h1>Tambah Supplier</h1>
    </div>
    <hr />
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Supplier"
                        required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="saldo_awal_utang">Saldo Awal Utang</label>
                    <input type="text" name="saldo_awal_utang" class="form-control" id="saldo_awal_utang"
                        placeholder="Saldo Awal Utang" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Nomor Telepon"
                        required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat Supplier" required></textarea>
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
