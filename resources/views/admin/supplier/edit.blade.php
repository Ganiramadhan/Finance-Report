@extends('layouts.admin.app', ['title' => 'Edit Supplier'])

@section('content')
    <div class="section-header">
        <h1>Edit Supplier</h1>
    </div>
    <hr />
    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama"
                        value="{{ $supplier->nama }}">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="saldo_awal_utang">Jumlah Utang</label>
                    <input type="text" name="saldo_awal_utang" class="form-control" id="saldo_awal_utang"
                        placeholder="Saldo Awal Utang" value="{{ $supplier->saldo_awal_utang }}">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Nomor Telepon"
                        value="{{ $supplier->no_telepon }}">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat" required>{{ $supplier->alamat }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection
