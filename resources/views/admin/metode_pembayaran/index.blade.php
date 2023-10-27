@extends('layouts.admin.app', ['title' => 'Rekening'])

@section('content')
    <div class="section-header">
        <h1><i class="fas fa-university" style="font-size: 1em;"></i> Data Akun Bank</h1>
    </div>

    <div class="row p-2">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>

    <hr />

    <div class="row">
        @if ($metode_pembayaran->count() > 0)
            @foreach ($metode_pembayaran as $row)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-credit-card"></i> {{ $row->metode_pembayaran }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text" style="font-size: 18px">
                                <i class="fas fa-money-bill saldo-icon"></i> Saldo Rekening:
                                <span class="saldo-animation" data-saldo="{{ $row->saldo }}">
                                    Rp {{ number_format($row->saldo, 0, ',', '.') }}.-
                                </span>
                            </p>


                        </div>
                        <div class="card-footer">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button id="btnActionsDropdown{{ $row->id }}" type="button"
                                    class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnActionsDropdown{{ $row->id }}">
                                    <a class="dropdown-item" href="{{ route('metode_pembayaran.edit', $row->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form id="deleteForm" action="{{ route('metode_pembayaran.destroy', $row->id) }}"
                                        method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini ?')">
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
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    Kategori pengeluaran not found
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil semua elemen dengan class "saldo-animation"
            var saldoElements = document.querySelectorAll(".saldo-animation");

            // Animasikan saldo
            saldoElements.forEach(function(saldoElement) {
                var saldo = saldoElement.getAttribute("data-saldo");
                var targetSaldo = parseInt(saldo);
                var currentSaldo = 0;
                var increment = targetSaldo /
                    100; // Ubah angka ini sesuai dengan kecepatan animasi yang Anda inginkan

                // Fungsi untuk mengupdate saldo saat animasi
                function updateSaldo() {
                    if (currentSaldo < targetSaldo) {
                        currentSaldo += increment;
                        saldoElement.textContent = "Rp " + currentSaldo.toFixed(0).replace(
                            /\d(?=(\d{3})+$)/g, "$&,") + ".-";
                        requestAnimationFrame(updateSaldo);
                    } else {
                        saldoElement.textContent = "Rp " + targetSaldo.toFixed(0).replace(
                            /\d(?=(\d{3})+$)/g, "$&,") + ".-";
                    }
                }

                // Memulai animasi
                updateSaldo();
            });
        });
    </script>
@endsection



<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tempatkan form create di sini -->
                <form action="{{ route('metode_pembayaran.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="rekening">Rekening</label>
                            <input type="text" name="metode_pembayaran" class="form-control" placeholder="Nama"
                                id="rekening">
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="saldo">Saldo Rekening</label>
                            <input type="text" name="saldo" class="form-control" placeholder="Saldo Rekening"
                                id="saldo">
                        </div>

                    </div>
                    <div class="row">
                        <div class="d-grid">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
