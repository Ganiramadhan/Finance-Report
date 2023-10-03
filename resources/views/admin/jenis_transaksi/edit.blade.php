@extends('layouts.admin.app', ['title' => 'Edit Jenis Transaksi'])

@section('content')
    <div class="section-header">
        <h1>Edit Jenis Transaksi</h1>
    </div>
    <hr />
    <form action="{{ route('jenis_transaksi.update', $jenis_transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Jenis Transaksi</label>
                <input type="text" name="jenis_transaksi" class="form-control" placeholder="Nama"
                    value="{{ $jenis_transaksi->jenis_transaksi }}">
                @error('jenis_transaksi')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
@endsection
