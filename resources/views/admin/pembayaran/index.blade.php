@extends('layouts.admin.app', ['title' => 'Pembayaran'])

@section('content')
    <div class="section-header">
        <h1><i class="fas fa-money-check" style="font-size: 1em;"></i> Data Pembayaran</h1>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Pembayaran" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Pembayaran
            </a>
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-print"></i> Cetak Pembayaran
            </button>
        </div>
    </div>

    <hr />
    {{-- @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif --}}
    <div class="table-responsive">

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Kode Pembayaran</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Penerima</th>
                    <th>Keterangan</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="pembayaran-list">
                @if ($pembayarans->count() > 0)
                    @foreach ($pembayarans as $row)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $row->kd_pembayaran }}</td>
                            <td class="align-middle">{{ $row->kategori_pengeluaran->nama_kategori }}</td>
                            <td class="align-middle">{{ $row->penerima }}</td>
                            <td class="align-middle">{{ $row->keterangan }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->jml_pembayaran, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            <td class="align-middle">{{ $row->tanggal }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <div class="btn-group" role="group">
                                        <button id="btnActionsDropdown" type="button"
                                            class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnActionsDropdown">
                                            <a class="dropdown-item" href="{{ route('pembayaran.show', $row->id) }}">
                                                <i class="fas fa-info-circle fa-lg"></i> Detail
                                            </a>
                                            <a class="dropdown-item" href="{{ route('pembayaran.edit', $row->id) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form id="deleteForm" action="{{ route('pembayaran.destroy', $row->id) }}"
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
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="9">Tidak ada data pembayaran</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $pembayarans->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pembayarans->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $pembayarans->lastPage(); $i++)
                <li class="page-item {{ $i == $pembayarans->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $pembayarans->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $pembayarans->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pembayarans->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $pembayarans->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('pembayaran.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#pembayaran-list').html(data.data);
                        currentPage = 1;
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                if (page === undefined) {
                    return;
                }
                currentPage = parseInt(page);
                $('.pagination li').removeClass('active');
                $(this).closest('li').addClass('active');
                $.ajax({
                    url: "{{ route('pembayaran.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#pembayaran-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $pembayarans->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Cetak Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembayaran.cetak_pdf') }}" method="get">
                    @csrf
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cetak PDF</button>
                </form>
            </div>
        </div>
    </div>
</div>
