@extends('layouts.admin.app', ['title' => 'Transaksi Lainya'])


@section('content')
    <style>
        /* Tambahkan efek transisi untuk baris tabel */
        tr {
            transition: all 0.2s ease-in-out;
        }

        /* Tambahkan efek perubahan opacity untuk baris yang tidak sesuai dengan filter */
        tr.filtered-out {
            opacity: 0.2;
        }
    </style>
    <div class="section-header">
        <h1><i class="fas fa-exchange-alt" style="font-size: 1em;"></i> Data Transaksi</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Transaksi" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('transaksi.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-print"></i> Cetak Transaksi
            </button>
        </div>
    </div>
    <div class="row mt-3 ">

        <div class="col-9">

        </div>

        <div class="col-md-3">
            {{-- <label for="jenis_transaksi_filter">Jenis Transaksi:</label> --}}
            <div class="input-group">
                <select class="form-control" id="jenis_transaksi_filter" name="jenis_transaksi_filter">
                    <option value="">Semua Transaksi</option>
                    @foreach ($jenisTransaksi as $jenis)
                        <option value="{{ $jenis->jenis_transaksi }}">{{ $jenis->jenis_transaksi }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-filter"></i>
                    </span>
                </div>
            </div>
            <div class="alertify" id="noResultsAlert" style="display: none;">
                Tidak ada transaksi dengan jenis transaksi yang dipilih.
            </div>
        </div>


    </div>
    </div>


    <hr />

    <div class="table-responsive">

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Kode Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Metode Pembayaran</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="transaksi-list">
                @if ($transaksis->count() > 0)
                    @foreach ($transaksis as $row)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $row->kd_transaksi }}</td>
                            <td class="align-middle">{{ $row->jenis_transaksi->jenis_transaksi }}</td>
                            <td class="align-middle">{{ $row->metode_pembayaran->metode_pembayaran }}</td>
                            <td class="align-middle">{{ $row->keterangan }}</td>
                            <td class="align-middle">{{ 'Rp ' . number_format($row->jumlah, 0, ',', '.') }}</td>
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
                                            <a class="dropdown-item" href="{{ route('transaksi.show', $row->id) }}">
                                                <i class="fas fa-info-circle fa-lg"></i> Detail
                                            </a>
                                            <a class="dropdown-item" href="{{ route('transaksi.edit', $row->id) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form id="deleteForm" action="{{ route('transaksi.destroy', $row->id) }}"
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
                        <td class="text-center" colspan="9">Data Transaksi tidak ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $transaksis->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $transaksis->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $transaksis->lastPage(); $i++)
                <li class="page-item {{ $i == $transaksis->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $transaksis->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $transaksis->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $transaksis->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jenisTransaksiFilter = document.getElementById('jenis_transaksi_filter');
            const transaksiList = document.getElementById('transaksi-list');

            jenisTransaksiFilter.addEventListener("change", function() {
                const selectedJenisTransaksi = jenisTransaksiFilter.value;
                const transaksiRows = transaksiList.querySelectorAll("tr");

                let noResults = true;

                transaksiRows.forEach(function(row) {
                    const jenisTransaksiCell = row.cells[2];
                    if (selectedJenisTransaksi === "" || jenisTransaksiCell.textContent ===
                        selectedJenisTransaksi) {
                        row.style.display = "table-row";
                        noResults = false;
                    } else {
                        row.style.display = "none";
                    }
                });

                // Tampilkan pesan alert menggunakan Alertify.js
                if (noResults) {
                    alertify.alert("Tidak ada transaksi dengan jenis transaksi yang dipilih.");
                }
            });
        });




        $(document).ready(function() {
            // Menggunakan jQuery untuk menangani perubahan dalam dropdown filter
            $('#jenis_transaksi_filter').change(function() {
                var jenisTransaksi = $(this).val();

                // Lakukan permintaan Ajax ke server untuk mengambil data yang sesuai dengan jenis transaksi yang dipilih
                $.ajax({
                    type: 'GET',
                    url: '/filter-transaksi', // Gantilah ini dengan rute yang sesuai di Laravel Anda
                    data: {
                        jenis_transaksi: jenisTransaksi
                    },
                    success: function(data) {
                        // Perbarui tabel dengan data yang diterima dari server
                        $('#transaksi-list').html(data);
                    }
                });
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const jenisTransaksiFilter = document.getElementById('jenis_transaksi_filter');
            const transaksiList = document.getElementById('transaksi-list');

            jenisTransaksiFilter.addEventListener("change", function() {
                const selectedJenisTransaksi = jenisTransaksiFilter.value;
                const transaksiRows = transaksiList.querySelectorAll("tr");

                transaksiRows.forEach(function(row) {
                    const jenisTransaksiCell = row.cells[2];
                    if (selectedJenisTransaksi === "" || jenisTransaksiCell.textContent ===
                        selectedJenisTransaksi) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });







        $(document).ready(function() {
            var currentPage = {{ $transaksis->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('transaksi.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#transaksi-list').html(data.data);
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
                    url: "{{ route('transaksi.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#transaksi-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $transaksis->lastPage() }});
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
                <h5 class="modal-title" id="filterModalLabel">Cetak Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaksi.cetak_pdf') }}" method="get">
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
