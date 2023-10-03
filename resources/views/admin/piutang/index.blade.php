@extends('layouts.admin.app', ['title' => 'Data Piutang'])

@section('content')
    <div class="section-header">
        <h1>Data Piutang</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Data Piutang" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('piutang.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
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
                    {{-- <th>Nomor</th> --}}
                    <th>Nama Customer</th>
                    <th>Jumlah Piutang</th>
                    <th>Pembayaran</th>
                    <th>Sisa Piutang</th>
                    <th>Keterangan</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="piutang-list">
                @if ($piutangs->count() > 0)
                    @foreach ($piutangs as $row)
                        <tr>
                            {{-- <td class="align-middle">{{ $row->id }}</td> --}}
                            <td class="align-middle">{{ $row->customer->nama }}</td>
                            <td class="align-middle">
                                {{ 'Rp ' . number_format($row->jumlah_piutang, 0, ',', '.') }}</td>

                            <td class="align-middle">{{ 'Rp ' . number_format($row->pembayaran, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->sisa_piutang, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->keterangan }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            <td class="align-middle">{{ $row->tanggal }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <a href="{{ route('transaksi.show', $row->id) }}" type="button" class="btn btn-secondary">
                                    <i class="fas fa-info-circle"></i>
                                </a> --}}

                                    {{-- <a href="{{ route('piutang.edit', $row->id) }}" type="button" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                    <form action="{{ route('piutang.destroy', $row->id) }}" method="POST"
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
                        <td class="text-center" colspan="9">Data tidak ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $piutangs->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $piutangs->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $piutangs->lastPage(); $i++)
                <li class="page-item {{ $i == $piutangs->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $piutangs->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $piutangs->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $piutangs->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $piutangs->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('piutang.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#piutang-list').html(data.data);
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
                    url: "{{ route('piutang.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#piutang-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $piutangs->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection
