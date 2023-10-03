@extends('layouts.admin.app', ['title' => 'Edit Piutang'])

@section('content')
    <div class="section-header">
        <h1>Edit Piutang</h1>
    </div>
    <hr />
    <form action="{{ route('piutang.update', $piutang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nama Customer</label>
                <select class="form-control" id="customer_id" name="customer_id" required>
                    <option value="">Pilih Customer</option>
                    @foreach ($data_customer as $item)
                        <option value="{{ $item->id }}" data-saldo="{{ $item->saldo_awal_piutang }}"
                            @if ($item->id == $piutang->customer_id) selected @endif>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col mb-3">
                <label class="form-label">Saldo Awal Piutang</label>
                <input type="text" name="saldo_awal_piutang" class="form-control" placeholder="Saldo Awal Piutang"
                    id="saldo_awal_piutang" value="{{ $piutang->customer->saldo_awal_piutang }}" required>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Pembayaran</label>
                    <input type="text" name="pembayaran" class="form-control" placeholder="pembayaran" id="pembayaran"
                        value="{{ $piutang->pembayaran }}"required>
                </div>


                <input type="hidden" name="sisa_piutang" class="form-control" placeholder="sisa_piutang" id="sisa_piutang"
                    value="{{ $piutang->sisa_piutang }}" required>


                <div class="col mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="keterangan" id="keterangan"
                        value="{{ $piutang->keterangan }}" required>
                </div>


                <div class="col mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran_id" name="metode_pembayaran_id" required>
                        <option value="">Metode Pembayaran</option>
                        @foreach ($data_metode_pembayaran as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $piutang->metode_pembayaran_id) selected @endif>
                                {{ $item->metode_pembayaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Tanggal piutang</label>
                    <input type="date" name="tanggal" class="form-control" placeholder="tanggal" id="tanggal"
                        value="{{ $piutang->tanggal }}" required>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var customerSelect = document.getElementById("customer_id");
        var saldoAwalPiutangInput = document.getElementById("saldo_awal_piutang");

        customerSelect.addEventListener("change", function() {
            var selectedCustomer = customerSelect.options[customerSelect.selectedIndex];
            var saldoAwalPiutang = selectedCustomer.getAttribute("data-saldo");

            saldoAwalPiutangInput.value = saldoAwalPiutang;
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var saldoAwalPiutangInput = document.getElementById("saldo_awal_piutang");
        var pembayaranInput = document.getElementById("pembayaran");
        var keteranganInput = document.getElementById("keterangan");
        var sisaPiutangInput = document.getElementById("sisa_piutang");

        // Fungsi untuk menghitung dan memperbarui Sisa Piutang dan Keterangan
        function updateSisaPiutang() {
            var saldoAwalPiutang = parseFloat(saldoAwalPiutangInput.value) || 0;
            var pembayaran = parseFloat(pembayaranInput.value) || 0;
            var sisaPiutang = saldoAwalPiutang - pembayaran;

            sisaPiutang = Math.max(0, sisaPiutang);

            if (sisaPiutang === 0) {
                keteranganInput.value = "Lunas";
            } else {
                keteranganInput.value = "Belum Lunas";
            }

            sisaPiutangInput.value = sisaPiutang.toFixed(2);
        }

        // Event listener untuk memanggil fungsi updateSisaPiutang saat pembayaranInput berubah
        pembayaranInput.addEventListener("input", updateSisaPiutang);

        // Memanggil fungsi updateSisaPiutang saat halaman dimuat
        updateSisaPiutang();
    });
</script>
