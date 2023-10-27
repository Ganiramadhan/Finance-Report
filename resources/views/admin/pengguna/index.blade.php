@extends('layouts.admin.app', ['title' => 'Data Pengguna'])

@section('content')
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
        <h1><i class="fas fa-users" style="font-size: 1em;"></i> Data Akun Pengguna</h1>
    </div>

    <div class="row ">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData">
            <i class="fas fa-user-plus"></i> Tambah User
        </button>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-6">
            <div class="accordion" id="adminAccordion">
                <div class="card mb-3">
                    <div class="card-header" id="adminHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#adminCollapse"
                                aria-expanded="false" aria-controls="adminCollapse">
                                <span class="badge badge-success badge-lg">Data Admin</span>
                            </button>
                        </h5>
                    </div>

                    <div id="adminCollapse" class="collapse" aria-labelledby="adminHeading" data-parent="#adminAccordion">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pengguna as $user)
                                        @if ($user->role_id == 1)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge badge-success">Admin</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group dropup" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('pengguna.edit', $user->id) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form id="deleteForm"
                                                                action="{{ route('pengguna.destroy', $user->id) }}"
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
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="accordion" id="userAccordion">
                <div class="card mb-3">
                    <div class="card-header" id="userHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#userCollapse"
                                aria-expanded="false" aria-controls="userCollapse">
                                <span class="badge badge-primary badge-lg">Data User</span>
                            </button>
                        </h5>
                    </div>
                    <div id="userCollapse" class="collapse" aria-labelledby="userHeading" data-parent="#userAccordion">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pengguna as $user)
                                        @if ($user->role_id == 2)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge badge-primary">User</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group dropup" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('pengguna.edit', $user->id) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form id="deleteForm"
                                                                action="{{ route('pengguna.destroy', $user->id) }}"
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
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="accordion" id="deletedAccordion">
                <div class="card mb-3">
                    <div class="card-header" id="deletedHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                data-target="#deletedCollapse" aria-expanded="false" aria-controls="deletedCollapse">
                                <span class="badge badge-danger badge-lg">Data Yang Sudah Dihapus</span>
                            </button>
                        </h5>
                    </div>
                    <div id="deletedCollapse" class="collapse" aria-labelledby="deletedHeading"
                        data-parent="#deletedAccordion">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pengguna as $user)
                                        @if ($user->deleted_at)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->role_id == 1)
                                                        <span class="badge badge-success">Admin</span>
                                                    @else
                                                        <span class="badge badge-primary">User</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group dropup" role="group"
                                                        aria-label="Basic example">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <form id="restoreForm"
                                                                action="{{ route('pengguna.restore', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-undo"></i> Pulihkan
                                                                </button>
                                                            </form>
                                                            <form id="forceDeleteForm"
                                                                action="{{ route('pengguna.forceDelete', $user->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Anda yakin ingin menghapus data ini secara permanen ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item delete-button">
                                                                    <i class="fas fa-trash"></i> Hapus Permanen
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
