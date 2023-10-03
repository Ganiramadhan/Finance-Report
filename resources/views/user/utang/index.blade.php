@extends('layouts.admin.appUser', ['title' => 'Data Utang'])

@section('content')
    <div class="section-header">
        <h1>Data Utang</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Data Utang" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
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
                    <th>Nama Supplier</th>
                    {{-- <th>Utang</th> --}}
                    <th>Jumlah Utang</th>
                    <th>Pembayaran</th>
                    <th>Sisa utang</th>
                    <th>Keterangan</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody id="utang-list">
                @if ($utangs->count() > 0)
                    @foreach ($utangs as $row)
                        <tr>
                            {{-- <td class="align-middle">{{ $row->id }}</td> --}}
                            <td class="align-middle">{{ $row->supplier->nama }}</td>
                            {{-- <td class="align-middle">
                            {{ 'Rp ' . number_format($row->supplier->saldo_awal_utang, 0, ',', '.') }}</td> --}}
                            <td class="align-middle">
                                {{ 'Rp ' . number_format($row->jumlah_utang, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->pembayaran, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->sisa_utang, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->keterangan }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            <td class="align-middle">{{ $row->tanggal }}</td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="9">Data Utang tidak ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center mt-3">
            <ul class="pagination">
                <li class="page-item {{ $utangs->previousPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $utangs->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $utangs->lastPage(); $i++)
                    <li class="page-item {{ $i == $utangs->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $utangs->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $utangs->nextPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $utangs->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $utangs->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('utang.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#utang-list').html(data.data);
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
                    url: "{{ route('utang.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#utang-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $utangs->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection
