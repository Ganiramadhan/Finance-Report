@extends('layouts.admin.appUser', ['title' => 'Penjualan'])

@section('content')
    <div class="section-header">
        <h1><i class="fas fa-shopping-cart" style="font-size: 1em;"></i> Data Penjualan</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Penjualan" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="penjualan/create" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Penjualan
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
                    <th>Nomor</th>
                    <th>Customer</th>
                    <th>Jenis Produk</th>
                    {{-- <th>Harga Beli</th> --}}
                    <th>Harga Produk </th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Satuan</th>
                    <th>Metode Pembayaran</th>
                    {{-- <th>Total Belanja</th>
                <th>Diskon</th>
                <th>Total Bayar</th>
                <th>Pembayaran</th>
                <th>Piutang</th>
                <th>NO Faktur</th>
                <th>Tanggal</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="penjualan-list">
                @if ($penjualans->count() > 0)
                    @foreach ($penjualans as $row)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $row->customer->nama }}</td>
                            <td class="align-middle">{{ $row->product->nama }}</td>
                            {{-- <td class="align-middle">{{ 'Rp ' . number_format($row->hrg_beli_satuan, 0, ',', '.') }}</td> --}}
                            <td class="align-middle">{{ 'Rp ' . number_format($row->hrg_jual_satuan, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->qty }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->total_harga, 0, ',', '.') }}</td>
                            <td class="align-middle">{{ $row->product->satuan }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            {{-- <td class="align-middle">{{ $row->total_belanja }}</td>
                        <td class="align-middle">{{ $row->diskon }}</td>
                        <td class="align-middle">{{ $row->total_bayar }}</td>
                        <td class="align-middle">{{ $row->pembayaran }}</td>
                        <td class="align-middle">{{ $row->piutang }}</td>
                        <td class="align-middle">{{ $row->no_faktur }}</td>
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
                                            <a class="dropdown-item" href="{{ route('show', ['id' => $row->id]) }}">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </a>


                                            <form id="deleteForm" action="{{ route('destroy', ['id' => $row->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item delete-button"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ini ?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                            </form>



                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="10">Data Penjualan tidak ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $penjualans->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $penjualans->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $penjualans->lastPage(); $i++)
                <li class="page-item {{ $i == $penjualans->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $penjualans->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $penjualans->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $penjualans->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $penjualans->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('penjualan.search_user') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#penjualan-list').html(data.data);
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
                    url: "{{ route('penjualan.search_user') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#penjualan-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $penjualans->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection
