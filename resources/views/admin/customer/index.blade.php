@extends('layouts.admin.app', ['title' => 'Customer'])

@section('content')
    <div class="section-header">
        <h1><i class="fas fa-users" style="font-size: 1em;"></i> Data Customer</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Customer" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('customer.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Customer
            </a>
            </a>
            <a href="/customer/cetak_pdf" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Data
            </a>

        </div>
    </div>
    <hr />

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jumlah Piutang</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="customer-list">
                @forelse ($customers as $customer)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $customer->nama }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($customer->saldo_awal_piutang, 0, ',', '.') }}
                        </td>
                        <td class="align-middle">{{ $customer->no_telepon }}</td>
                        <td class="align-middle">{{ $customer->alamat }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="btn-group" role="group">
                                    <button id="btnActionsDropdown" type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnActionsDropdown">
                                        <a class="dropdown-item" href="{{ route('customer.show', $customer->id) }}">
                                            <i class="fas fa-info-circle fa-lg"></i> Detail
                                        </a>
                                        <a class="dropdown-item" href="{{ route('customer.edit', $customer->id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form id="deleteForm" action="{{ route('customer.destroy', $customer->id) }}"
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
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Customer not found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $customers->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $customers->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $customers->lastPage(); $i++)
                <li class="page-item {{ $i == $customers->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $customers->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $customers->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $customers->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $customers->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('customer.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#customer-list').html(data.data);
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
                    url: "{{ route('customer.search') }}",

                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#customer-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $customers->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection
