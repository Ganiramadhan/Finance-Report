@extends('layouts.admin.app', ['title' => 'Edit Kategori Pengeluaran'])

@section('content')
    <div class="section-header">
        <h1>Edit Kategori Pengeluaran</h1>
    </div>
    <hr />
    <form action="{{ route('kategori_pengeluaran.update', $kategori_pengeluaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Nama"
                    value="{{ $kategori_pengeluaran->nama_kategori }}">
            </div>
            <div class="row">
                <div class="d-grid">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
    </form>
@endsection
