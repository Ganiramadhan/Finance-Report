@extends('layouts.admin.app', ['title' => 'Edit Utang'])

@section('content')
    <div class="section-header">
        <h1>Edit Utang</h1>
    </div>
    <hr />
    <form action="{{ route('utang.update', $utang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nama Supplier</label>
                <select class="form-control" id="supplier_id" name="supplier_id" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($data_supplier as $item)
                        <option value="{{ $item->id }}" data-saldo="{{ $item->saldo_awal_utang }}"
                            @if ($item->id == $utang->supplier_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col mb-3">
                <label class="form-label">Saldo Awal Utang</label>
                <input type="text" name="saldo_awal_utang" class="form-control" placeholder="Saldo Awal utang"
                    id="saldo_awal_utang" value="{{ $utang->jumlah_utang }}" required readonly>
            </div>
            <div class="col mb-3">
                <label class="form-label">Jumlah Utang</label>
                <input type="text" name="jumlah_utang" class="form-control" placeholder="Saldo Awal utang"
                    id="jumlah_utang" value="{{ $utang->jumlah_utang }}" required readonly>
            </div>

            <div class="col mb-3">
                <label class="form-label">Pembayaran</label>
                <input type="text" name="pembayaran" class="form-control" placeholder="Pembayaran" id="pembayaran"
                    value="{{ $utang->pembayaran }}" required>
            </div>

            <div class="col mb-3">
                <label class="form-label">Sisa Utang</label>
                <input type="text" name="sisa_utang" class="form-control" placeholder="Sisa Utang" id="sisa_utang"
                    value="{{ $utang->sisa_utang }}" required readonly>
            </div>

            <div class="col mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" id="keterangan"
                    value="{{ $utang->keterangan }}" required>
            </div>

            <div class="col mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                    <option value="">Metode Pembayaran</option>
                    @foreach ($data_metode_pembayaran as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $utang->metode_pembayaran_id) selected @endif>
                            {{ $item->metode_pembayaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col mb-3">
                <label class="form-label">Tanggal Utang</label>
                <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Utang" id="tanggal"
                    value="{{ $utang->tanggal }}" required>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var supplierSelect = document.getElementById("supplier_id");
            // var saldoAwalUtangInput = document.getElementById("saldo_awal_utang");
            var pembayaranInput = document.getElementById("pembayaran");
            var keteranganInput = document.getElementById("keterangan");
            var sisaUtangInput = document.getElementById("sisa_utang");

            function updateSisaUtang() {
                var supplierOption = supplierSelect.options[supplierSelect.selectedIndex];
                var saldoAwalUtang = parseFloat(supplierOption.getAttribute("data-saldo")) || 0;
                var pembayaran = parseFloat(pembayaranInput.value) || 0;
                var sisaUtang = saldoAwalUtang - pembayaran;
                sisaUtang = Math.max(0, sisaUtang);

                if (sisaUtang === 0) {
                    keteranganInput.value = "Lunas";
                } else {
                    keteranganInput.value = "Belum Lunas";
                }

                saldoAwalUtangInput.value = saldoAwalUtang.toFixed(2); // Update saldo awal utang
                sisaUtangInput.value = sisaUtang.toFixed(2);
            }

            supplierSelect.addEventListener("change", updateSisaUtang);
            pembayaranInput.addEventListener("input", updateSisaUtang);

            updateSisaUtang(); // Panggil fungsi saat halaman dimuat
        });


        document.addEventListener("DOMContentLoaded", function() {
            var supplierSelect = document.getElementById("supplier_id");
            var saldoAwalUtangInput = document.getElementById("saldo_awal_utang");
            var pembayaranInput = document.getElementById("pembayaran");
            var keteranganInput = document.getElementById("keterangan");
            var sisaUtangInput = document.getElementById("sisa_utang");

            function updateSisaUtang() {
                var supplierOption = supplierSelect.options[supplierSelect.selectedIndex];
                var saldoAwalUtang = parseFloat(supplierOption.getAttribute("data-saldo")) || 0;
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

            supplierSelect.addEventListener("change", updateSisaUtang);
            pembayaranInput.addEventListener("input", updateSisaUtang);

            updateSisaUtang();
        });
    </script>
@endsection
