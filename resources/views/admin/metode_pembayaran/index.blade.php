@extends('layouts.admin.app', ['title' => 'Rekening'])

@section('content')
    <div class="section-header">
        <h1>Data Akun Bank</h1>
    </div>
    {{-- <div class="row">

        <h5 class="mb-0"></h5>
        <a href="{{ route('metode_pembayaran.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div> --}}

    <hr />
    {{-- @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif --}}
            <div class="table-responsive">

    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Jenis Rekening</th>
                <th>Saldo Rekening</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($metode_pembayaran->count() > 0)
                @foreach ($metode_pembayaran as $row)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $row->metode_pembayaran }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($row->saldo, 0, ',', '.') }}</td>
                        {{-- <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('metode_pembayaran.edit', $row->id) }}" type="button"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('metode_pembayaran.destroy', $row->id) }}" method="POST"
                                    type="button" class="btn btn-danger p-0"
                                    onsubmit="return confirm('Apakah Yakin ingin menghapus data ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td> --}}
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Kategori pengeluaran not found</td>
                </tr>
            @endif
        </tbody>
    </table>
          </div>
@endsection
