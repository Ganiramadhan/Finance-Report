@extends('layouts.admin.app', ['title' => 'Edit Rekening'])

@section('content')
    <div class="section-header">
        <h1>Edit Rekening</h1>
    </div>
    <hr />
    <form action="{{ route('metode_pembayaran.update', $metode_pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Rekening</label>
                <input type="text" name="metode_pembayaran" class="form-control" placeholder="Metode Pembayaran"
                    value="{{ $metode_pembayaran->metode_pembayaran }}">
            </div>
            <div class="col mb-3">
                <label class="form-label">Saldo</label>
                <input type="text" name="saldo" class="form-control" placeholder="Metode Pembayaran"
                    value="{{ $metode_pembayaran->saldo }}">
            </div>
            <div class="row">
                <div class="d-grid">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
    </form>
@endsection
