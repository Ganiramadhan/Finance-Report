@extends('layouts.admin.app', ['title' => 'Tambah Jenis Transaksi'])

@section('content')
    <div class="section-header">
        <h1> Tambah Jenis Transaksi</h1>
    </div>
    <hr />
    <form action="{{ route('jenis_transaksi.store') }}" method="POST">
        @csrf
        <div class="row">

            <div class="col m-2">
                <label class="form-label">Jenis Transaksi</label>
                <input type="text" name="jenis_transaksi" class="form-control" placeholder="Jenis Transaksi" required
                    value="{{ old('jenis_transaksi') }}">
                @error('jenis_transaksi')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col m-2">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="Pemasukan" {{ old('kategori') === 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="Pengeluaran" {{ old('kategori') === 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran
                    </option>
                </select>
            </div>

        </div>
        <div class="row m-2">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
