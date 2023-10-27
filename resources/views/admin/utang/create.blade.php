@extends('layouts.admin.app', ['title' => 'Tambah Utang'])

@section('content')
    <div class="section-header">
        <h1>Tambah Utang</h1>
    </div>
    <hr />
    {{-- @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}
    <form action="{{ route('utang.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label for="supplier_id">Nama Supplier</label>
                    <select class="form-control" id="supplier_id" name="supplier_id" required>
                        <option value="">Pilih Nama Supplier</option>
                        @foreach ($data_supplier as $item)
                            <option value="{{ $item->id }}" data-saldo="{{ $item->saldo_awal_utang }}">
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="saldo_awal_utang">Saldo Awal Utang</label>
                    <input type="text" name="saldo_awal_utang" id="saldo_awal_utang" class="form-control"
                        placeholder="Saldo Awal Utang" required readonly>
                </div>
            </div>
            {{-- <label for="jumlah_utang">Jumlah Utang</label> --}}
            <input type="hidden" name="jumlah_utang" id="jumlah_utang" class="form-control" placeholder="Jumlah Utang"
                required readonly>
            <div class="col">
                <div class="form-group">
                    <label for="pembayaran">Jumlah Pembayaran</label>
                    <input type="text" name="pembayaran" id="pembayaran" class="form-control"
                        placeholder="Jumlah Pembayaran" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="sisa_utang">Sisa Utang</label>
                    <input type="text" name="sisa_utang" id="sisa_utang" class="form-control" placeholder="Sisa Piutang"
                        required readonly>
                </div>
            </div>
            <div class="col">
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
            <div class="col-8">
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"
                        required readonly>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="tanggal">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal Transaksi"
                        required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var saldoAwalUtangInput = document.getElementById("saldo_awal_utang");
            var jumlahUtangInput = document.getElementById("jumlah_utang");
            var pembayaranInput = document.getElementById("pembayaran");
            var keteranganInput = document.getElementById("keterangan");
            var sisaUtangInput = document.getElementById("sisa_utang");
            var supplierSelect = document.getElementById("supplier_id");

            // Fungsi untuk menghitung jumlah utang
            function hitungJumlahUtang() {
                var saldoAwalUtang = parseFloat(saldoAwalUtangInput.value) || 0;
                var pembayaran = parseFloat(pembayaranInput.value) || 0;
                var sisaUtang = saldoAwalUtang - pembayaran;

                sisaUtang = Math.max(0, sisaUtang);

                if (sisaUtang === 0) {
                    keteranganInput.value = "Lunas";
                } else {
                    keteranganInput.value = "Belum Lunas";
                }

                sisaUtangInput.value = sisaUtang.toFixed(2);
            }

            // Event listener saat supplier dipilih
            supplierSelect.addEventListener("change", function() {
                var selectedOption = supplierSelect.options[supplierSelect.selectedIndex];
                var selectedSupplierSaldo = selectedOption.getAttribute("data-saldo");
                saldoAwalUtangInput.value = selectedSupplierSaldo;
                jumlahUtangInput.value = selectedSupplierSaldo;

                // Hitung jumlah utang saat supplier berubah
                hitungJumlahUtang();
            });

            // Event listener saat pembayaran berubah
            pembayaranInput.addEventListener("input", function() {
                // Hitung jumlah utang saat pembayaran berubah
                hitungJumlahUtang();
            });

            // Hitung jumlah utang saat halaman dimuat
            hitungJumlahUtang();
        });
    </script>
@endsection
