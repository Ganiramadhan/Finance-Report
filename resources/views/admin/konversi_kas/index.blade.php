@extends('layouts.app')

@section('body')
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Data Konversi Kas</h5>
        <a href="{{ route('konversi_kas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Kode Konversi Kas</th>
                <th>Rekening Asal</th>
                <th>Rekening Tujuan</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($konversi_kas->count() > 0)
                @foreach ($konversi_kas as $row)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $row->kd_konversi_kas }}</td>
                        <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                        <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                        <td class="align-middle">{{ $row->keterangan }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($row->jumlah, 0, ',', '.') }}</td>
                        <td class="align-middle">{{ $row->tanggal }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('penjualan.edit', $row->id) }}" type="button" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('penjualan.destroy', $row->id) }}" method="POST"
                                    class="btn btn-danger p-0"
                                    onsubmit="return confirm('Apakah anda ingin menghapus data ini?')">
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
                    <td class="text-center" colspan="6">Data tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
