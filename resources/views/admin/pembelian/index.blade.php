@extends('layouts.admin.app', ['title' => 'Pembelian'])

@section('content')
    <div class="section-header">
        <h1><i class="fas fa-shopping-bag" style="font-size: 1em;"></i> Data Pembelian</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Pembelian" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('pembelian.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Pembelian
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-print"></i> Cetak Pembelian
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
                    <th>Nomor</th>
                    <th>Kode Transaksi</th>
                    <th>Jenis Produk</th>
                    <th>Harga Produk</th>
                    {{-- <th>Harga Jual</th> --}}
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    {{-- <th>Total Belanja</th>
                <th>Diskon</th>
                <th>Total Bayar</th>
                <th>Pembayaran</th>
                <th>Utang</th>
                <th>Tanggal</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="pembelian-list">
                @if ($pembelians->count() > 0)
                    @foreach ($pembelians as $row)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $row->kd_transaksi }}</td>
                            <td class="align-middle">{{ $row->product->nama }}</td>
                            {{-- <td class="align-middle">{{ 'Rp ' . number_format($row->hrg_beli_satuan, 0, ',', '.') }}</td> --}}
                            <td class="align-middle">{{ 'Rp ' . number_format($row->hrg_jual_satuan, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->qty }}</td>
                            <td class="align-middle">{{ $row->product->satuan }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->total_harga, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            {{-- <td class="align-middle">{{ $row->supplier->nama }}</td> --}}
                            {{-- <td class="align-middle">{{ $row->total_belanja }}</td>
                        <td class="align-middle">{{ $row->diskon }}</td>
                        <td class="align-middle">{{ $row->total_bayar }}</td>
                        <td class="align-middle">{{ $row->pembayaran }}</td>
                        <td class="align-middle">{{ $row->utang }}</td>
                        <td class="align-middle">{{ $row->tanggal }}</td> --}}

                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <div class="btn-group" role="group">
                                        <button id="btnActionsDropdown" type="button"
                                            class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnActionsDropdown">
                                            <a class="dropdown-item" href="{{ route('pembelian.show', $row->id) }}">
                                                <i class="fas fa-info-circle fa-lg"></i> Detail
                                            </a>
                                            {{-- <a class="dropdown-item" href="{{ route('pembelian.edit', $row->id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a> --}}
                                            <form id="deleteForm" action="{{ route('pembelian.destroy', $row->id) }}"
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
                        <td class="text-center" colspan="9">Data Pembelian ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $pembelians->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pembelians->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $pembelians->lastPage(); $i++)
                <li class="page-item {{ $i == $pembelians->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $pembelians->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $pembelians->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pembelians->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $pembelians->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('pembelian.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#pembelian-list').html(data.data);
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
                    url: "{{ route('pembelian.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#pembelian-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $pembelians->lastPage() }});
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
                <h5 class="modal-title" id="filterModalLabel">Cetak pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembelian.cetak_pdf') }}" method="get">
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
