@extends('layouts.admin.app', ['title' => 'Kategori Pengeluaran'])

@section('content')
    <div class="section-header">
        <h1>Kategori Pengeluaran</h1>
    </div>
    <a href="{{ route('kategori_pengeluaran.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Data
    </a>

    <hr />

    <div class="row">
        @if ($kategori_pengeluaran->count() > 0)
            @foreach ($kategori_pengeluaran as $row)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <i class="fas fa-file-alt mr-2"></i> {{ $row->nama_kategori }}
                                </h5>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop{{ $row->id }}" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $row->id }}">
                                        <a class="dropdown-item" href="{{ route('kategori_pengeluaran.edit', $row->id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form id="deleteForm" action="{{ route('kategori_pengeluaran.destroy', $row->id) }}"
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
                <p class="text-center">Kategori pengeluaran not found</p>
            </div>
        @endif
    </div>
@endsection
