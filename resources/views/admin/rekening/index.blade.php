@extends('layouts.app')

@section('body')
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Data Rekening</h5>
        {{-- <a href="{{ route('rekening.create') }}" class="btn btn-primary">Tambah Data</a> --}}
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Jenis Rekening</th>
                <th>Saldo</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($rekening->count() > 0)
                @foreach ($rekening as $row)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $row->jenis_rekening }}</td>
                        <td class="align-middle">{{ $row->saldo }}</td>
                        {{-- <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">

                                <a href="{{ route('rekening.edit', $row->id) }}" type="button"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('rekening.destroy', $row->id) }}" method="POST" type="button"
                                    class="btn btn-danger p-0"
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
                    <td class="text-center" colspan="5">rekening not found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
