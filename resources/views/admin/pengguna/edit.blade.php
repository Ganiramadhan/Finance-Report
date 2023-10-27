@extends('layouts.admin.app', ['title' => 'Edit Akun Pengguna'])

@section('content')
    <div class="section-header">
        <h1>Edit Akun Pengguna</h1>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Akun Pengguna</h5>
                <div class="form-group">
                    <label for="editName">Nama</label>
                    <div class="card-text" style="font-size: 16px;">{{ $user->name }}</div>
                </div>

                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <div class="card-text" style="font-size: 16px;">{{ $user->email }}</div>
                </div>
                <div class="form-group">
                    @if ($user->role_id === 1)
                        <span class="badge badge-success" style="font-size: 16px;">
                            <i class="fas fa-user-shield"></i> Admin
                        </span>
                    @elseif($user->role_id === 2)
                        <span class="badge badge-primary" style="font-size: 16px;">
                            <i class="fas fa-user"></i> User
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-edit"></i> Edit Akun Pengguna
            </button>
        </div>



    </div>



    <!-- Modal Edit -->
@endsection

@section('scripts')
    <script>
        // Mengatur role_id berdasarkan opsi yang dipilih
        $('#editStatus').change(function() {
            var selectedValue = $(this).val();
            // Tidak perlu mengubah elemen select[name="role_id"]
        });
    </script>
@endsection
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Akun Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="editName">Nama</label>
                        <input type="text" name="name" class="form-control" id="editName" placeholder="Nama"
                            value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="editEmail" placeholder="Email"
                            value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="editPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="editPassword"
                            placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select name="role_id" class="form-control" id="editStatus" required>
                            <option value="1" {{ $user->role_id === 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ $user->role_id === 2 ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
