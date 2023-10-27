@extends('layouts.admin.app', ['title' => 'Tambah Piutang'])

@section('content')

@section('content')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error'
            });
        </script>
    @endif

    <div class="section-header">
        <h1>Tambah Piutang</h1>
    </div>
    <hr />
    <form action="{{ route('piutang.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="customer_id">Nama Customer</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                        <option value="">Pilih Nama Customer</option>
                        @foreach ($data_customer as $item)
                            <option value="{{ $item->id }}" data-saldo="{{ $item->saldo_awal_piutang }}">
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="saldo_awal_piutang">Saldo Awal Piutang</label>
                    <input type="text" name="saldo_awal_piutang" id="saldo_awal_piutang" class="form-control"
                        placeholder="Saldo Awal Piutang" required readonly>
                </div>
            </div>

            {{-- <label for="jumlah_piutang">Jumlah Piutang</label> --}}
            <input type="hidden" name="jumlah_piutang" id="jumlah_piutang" class="form-control"
                placeholder="Saldo Awal Piutang" required readonly>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="pembayaran">Jumlah Pembayaran</label>
                    <input type="number" name="pembayaran" id="pembayaran" class="form-control"
                        placeholder="Jumlah Pembayaran" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="sisa_piutang">Sisa Piutang</label>
                    <input type="number" name="sisa_piutang" id="sisa_piutang" class="form-control"
                        placeholder="Sisa Piutang" required readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="metode_pembayaran_id">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        @foreach ($data_metode_pembayaran as $item)
                            <option value="{{ $item->id }}">{{ $item->metode_pembayaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"
                        required readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                        required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var saldoAwalPiutangInput = document.getElementById("saldo_awal_piutang");
            var jumlahPiutangInput = document.getElementById("jumlah_piutang");
            var pembayaranInput = document.getElementById("pembayaran");
            var sisaPiutangInput = document.getElementById("sisa_piutang");
            var customerSelect = document.getElementById("customer_id");
            var keteranganInput = document.getElementById("keterangan");

            customerSelect.addEventListener("change", function() {
                var selectedOption = customerSelect.options[customerSelect.selectedIndex];
                var selectedCustomerSaldo = parseFloat(selectedOption.getAttribute("data-saldo")) || 0;
                saldoAwalPiutangInput.value = selectedCustomerSaldo.toFixed(2);
                jumlahPiutangInput.value = selectedCustomerSaldo.toFixed(2);
                updateSisaPiutang();
            });

            pembayaranInput.addEventListener("input", function() {
                updateSisaPiutang();
            });

            function updateSisaPiutang() {
                var saldoAwalPiutang = parseFloat(saldoAwalPiutangInput.value) || 0;
                var pembayaran = parseFloat(pembayaranInput.value) || 0;
                var sisaPiutang = saldoAwalPiutang - pembayaran;

                sisaPiutang = Math.max(0, sisaPiutang);

                sisaPiutangInput.value = sisaPiutang.toFixed(2);

                // Tambahkan logika untuk mengisi otomatis keterangan
                if (sisaPiutang === 0) {
                    keteranganInput.value = "Lunas";
                } else {
                    keteranganInput.value = "Belum Lunas";
                }
            }
        });
    </script>
@endsection
