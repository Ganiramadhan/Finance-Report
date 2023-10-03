@extends('layouts.admin.app', ['title' => 'Product'])

@section('content')
    <div class="section-header">
        <h1>Data Produk</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="search-element">
                <input class="form-control" placeholder="Cari Produk" aria-label="Search" data-width="250" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-6 text-right">
            <h5 class="mb-0"></h5>
            <a href="{{ route('product.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>Nomor</th>
                    <th>Nama Produk</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Total Harga</th>
                    <th>Harga Jual</th>
                    <th>Satuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="product-list">
                @forelse ($products as $product)
                    <tr>
                        <td class="align-middle">{{ $product->id }}</td>
                        <td class="align-middle">{{ $product->nama }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($product->hrg_beli, 0, ',', '.') }}</td>
                        <td class="align-middle">{{ $product->qty }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($product->total, 0, ',', '.') }}</td>
                        <td class="align-middle">{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</td>
                        <td class="align-middle">{{ $product->satuan }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                    class="btn btn-danger p-0"
                                    onsubmit="return confirm('Anda yakin ingin menghapus data ini ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger m-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada produk yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="pagination" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item {{ $products->previousPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $products->lastPage(); $i++)
                <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $products->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentPage = {{ $products->currentPage() }};

            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('product.search') }}",
                    type: "GET",
                    data: {
                        'query': query,
                        'page': currentPage
                    },
                    success: function(data) {
                        $('#product-list').html(data.data);
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
                    url: "{{ route('product.search') }}",
                    type: "GET",
                    data: {
                        'query': $('#search').val(),
                        'page': page
                    },
                    success: function(data) {
                        $('#product-list').html(data.data);
                        updateTableNumber();
                        updatePaginationButtons();
                    }
                });
            });

            function updatePaginationButtons() {
                $('.pagination li:first-child').toggleClass('disabled', currentPage === 1);
                $('.pagination li:last-child').toggleClass('disabled', currentPage ===
                    {{ $products->lastPage() }});
            }

            updatePaginationButtons();
        });
    </script>
@endsection
