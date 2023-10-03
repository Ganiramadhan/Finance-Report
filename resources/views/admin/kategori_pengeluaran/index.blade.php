@extends('layouts.admin.app', ['title' => 'Kategori Pengeluaran'])

@section('content')
    <div class="section-header">
        <h1>Kategori Pengeluaran</h1>
    </div>
    <div class="row">


        <a href="{{ route('kategori_pengeluaran.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Data
        </a>

    </div>

    <hr />
    {{-- @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif --}}
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($kategori_pengeluaran->count() > 0)
                @foreach ($kategori_pengeluaran as $row)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $row->nama_kategori }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('kategori_pengeluaran.edit', $row->id) }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kategori_pengeluaran.destroy', $row->id) }}" method="POST"
                                    class="btn btn-danger p-0"
                                    onsubmit="return confirm('Anda yakin ingin menghapus data ini ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Kategori pengeluaran not found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
