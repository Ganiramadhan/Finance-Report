@extends('layouts.admin.app', ['title' => 'Profil Pengguna'])

@section('content')
    <style>
        .larger-font {
            font-size: 18px;
        }

        .larger-button {
            font-size: 18px;
            /* Ukuran font tombol */
            padding: 10px 20px;
            /* Padding tombol */
        }
    </style>
    @error('email')
        <script>
            $(document).ready(function() {
                // Tampilkan pesan kesalahan menggunakan Alertify dengan warna merah
                alertify.alert('Error', '{{ $message }}').setHeader('Validation Error').set('basic', true).set(
                    'modal', true);
                // Menambahkan kelas CSS untuk warna merah pada pesan Alertify
                $(".ajs-modal").addClass("ajs-error-background");
                $(".ajs-header").addClass("ajs-error");
            });
        </script>
    @enderror

    <div class="section-header">
        <h1><i class="fas fa-user" style="font-size: 1em;"></i> Profil Pengguna</h1>
    </div>
    <hr />

    <div class="row">
        @foreach ($data_users as $user)
            @if ($user->id === Auth::user()->id)
                <div class="col-md-5 mx-auto mb-4">
                    <div class="card rounded">
                        <div class="card-body text-left">
                            <div class="user-avatar">
                                <img src="{{ asset($user->profile) }}" alt="Foto Profil" class="avatar-img"
                                    style="display: block; margin: 0 auto; border-radius: 50%;" width="200px"
                                    height="200px">
                            </div>
                            <h5 class="card-title mt-3 font-size-24 larger-font">{{ $user->name }}</h5>
                            <p class="card-text font-size-18 larger-font"><i class="fas fa-envelope"></i> Email:
                                {{ $user->email }}</p>
                            <p class="card-text font-size-18 larger-font"><i class="fas fa-phone"></i> Nomor Telepon:
                                {{ $user->no_telepon }}</p>
                            <p class="card-text font-size-18 larger-font"><i class="fas fa-venus-mars"></i> Jenis Kelamin:
                                {{ $user->jenis_kelamin }}</p>
                            <p class="card-text font-size-18 larger-font"><i class="fas fa-map-marker-alt"></i> Alamat:
                                {{ $user->alamat }}</p>

                            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary larger-button">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    </div>
@endsection






<!-- Modal untuk menambahkan data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Tambahkan field-form Anda untuk menambahkan data di sini -->
                    <input type="hidden" id="role_id" name="role_id"> <!-- Input tersembunyi untuk role_id -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>


                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- Tambahkan lebih banyak field sesuai kebutuhan -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Tambahkan skrip JavaScript untuk mengatur nilai 'role_id' berdasarkan pilihan 'status'
    document.addEventListener("DOMContentLoaded", function() {
        var statusSelect = document.getElementById("status");
        var roleIdInput = document.getElementById("role_id");

        statusSelect.addEventListener("change", function() {
            if (statusSelect.value === "Admin") {
                roleIdInput.value = 1; // Jika status 'Admin' dipilih, set 'role_id' ke 1
            } else if (statusSelect.value === "User") {
                roleIdInput.value = 2; // Jika status 'User' dipilih, set 'role_id' ke 2
            }
        });
    });
</script>
