@extends('layouts.admin.app', ['title' => 'Edit Akun Pengguna'])

@section('content')
    <div class="section-header">
        <h1>Edit Profile</h1>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Akun Pengguna</h5>
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="password" class="form-control" id="editPassword" placeholder="Password"
                            required>
                        <div class="form-group">
                            <img src="{{ asset($user->profile) }}" alt="Foto Profil" class="avatar-img"
                                style="display: block; margin: 0 auto; border-radius: 50%;" width="200px" height="200px">
                            <div class="custom-file mt-4">
                                <input type="file" class="custom-file-input" id="editProfile" name="profile"
                                    accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label"
                                    for="editProfile">{{ $user->profile ? basename($user->profile) : 'Pilih File' }}</label>
                                @if ($errors->has('profile'))
                                    <div class="text-danger">{{ $errors->first('profile') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" name="name" class="form-control" id="editName" placeholder="Nama"
                                value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" name="email" class= "form-control" id="editEmail" placeholder="Email"
                                value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editNomorTelepon">Nomor Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" id="editNomorTelepon"
                                placeholder="Nomor Telepon" value="{{ $user->no_telepon }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editJenisKelamin">Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" class="form-control" id="editJenisKelamin"
                                placeholder="Jenis Kelamin" value="{{ $user->jenis_kelamin }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editAlamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="editAlamat" placeholder="Alamat"
                                value="{{ $user->alamat }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.avatar-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);

            // Update label dengan nama file gambar yang dipilih
            $('.custom-file-label').text(input.files[0].name);
        }
    }
</script>
