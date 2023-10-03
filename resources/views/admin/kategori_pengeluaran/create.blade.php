@extends('layouts.admin.app', ['title' => 'Tambah Kategori Pengeluaran'])

@section('content')
    <div class="section-header">
        <h1>Tambah Kategori Pengeluaran</h1>
    </div>
    <hr />
    <form action="{{ route('kategori_pengeluaran.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_kategori" class="form-control" placeholder="Kategori Pengeluaran">
            </div>

        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
