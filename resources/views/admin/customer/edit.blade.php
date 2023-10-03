@extends('layouts.admin.app', ['title' => 'Edit Customer'])

@section('content')
    <div class="section-header">
        <h1>Edit Customer</h1>
    </div>
    <hr />

    <form action="{{ route('customer.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama"
                        value="{{ $customer->nama }}" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="saldo_awal_piutang">Jumlah Piutang</label>
                    <input type="number" name="saldo_awal_piutang" class="form-control" id="saldo_awal_piutang"
                        placeholder="Saldo Awal Piutang" value="{{ $customer->saldo_awal_piutang }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat" required>{{ $customer->alamat }}</textarea>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Nomor Telepon"
                        value="{{ $customer->no_telepon }}" required>
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
