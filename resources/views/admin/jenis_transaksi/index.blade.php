@extends('layouts.admin.app', ['title' => 'Jenis Transaksi'])

@section('content')
    <style>
        .ajs-modal.ajs-error-background {
            color: red;
            font-size: 15px;
            font-style: italic
        }
    </style>

    @error('jenis_transaksi')
        <script>
            $(document).ready(function() {
                // Tampilkan pesan kesalahan menggunakan Alertify dengan warna merah
                alertify.alert('Error', '{{ $message }}').setHeader('Validation Error').set('basic', true).set(
                    'modal', true);
                // Menambahkan kelas CSS untuk warna merah pada pesan Alertify
                $(".ajs-modal").addClass("ajs-error-background");
                $(".ajs-header").addClass("ajs-error");
            });
        </script>
    @enderror

    <div class="section-header">
        <h1>Jenis Transaksi</h1>
    </div>
    <h5 class="mb-2"></h5>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
        <i class="fas fa-user-plus"></i> Tambah Jenis Transaksi
    </button>


    <hr />

    <div class="row">
        @if ($jenis_transaksi->count() > 0)
            @foreach ($jenis_transaksi as $row)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $row->jenis_transaksi }}</h5>
                            <p class="card-title">Kategori : {{ $row->kategori }}</p>
                            <div class="btn-group" role="group" aria-label="Basic example">

                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop{{ $row->id }}" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $row->id }}">
                                        <a class="dropdown-item" href="{{ route('jenis_transaksi.edit', $row->id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form id="deleteForm" action="{{ route('jenis_transaksi.destroy', $row->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menghapus data ini ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-button">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <p class="text-center">jenis_transaksi not found</p>
            </div>
        @endif
    </div>
@endsection



<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Jenis Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-2">
                <form action="{{ route('jenis_transaksi.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col m-2">
                            <label class="form-label">Jenis Transaksi</label>
                            <input type="text" name="jenis_transaksi" class="form-control"
                                placeholder="Jenis Transaksi" required>
                            @error('jenis_transaksi')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col m-2">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="d-grid">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
