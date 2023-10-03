@extends('layouts.admin.app', ['title' => 'Tambah Rekening'])

@section('content')
    <div class="section-header">
        <h1>Tambah Rekening</h1>
    </div>
    <hr />
    <form action="{{ route('metode_pembayaran.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="metode_pembayaran" class="form-control" placeholder="Nama">
            </div>

        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
