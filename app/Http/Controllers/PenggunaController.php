<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $data_pengguna = User::orderBy('name', 'asc')->get();

        return view('admin.pengguna.index', compact('data_pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */


    // Metode untuk menyimpan data yang ditambahkan
    public function create()
    {
        return view('pengguna.index');
    }
    public function store(Request $request)
    {
        // Validasi input (tanpa validasi untuk 'status')
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:3',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
        ]);


        // Set nilai role_id berdasarkan pilihan status
        $role_id = ($request->input('status') === 'Admin') ? 1 : 2;

        // Simpan data ke dalam database
        $pengguna = new User();
        $pengguna->name = $validatedData['name'];
        $pengguna->email = $validatedData['email'];
        $pengguna->password = bcrypt($validatedData['password']); // Jangan lupa untuk menghash password
        $pengguna->role_id = $role_id; // Gunakan nilai role_id yang telah diatur
        // Simpan lebih banyak field sesuai kebutuhan Anda

        $pengguna->save();

        // Redirect ke halaman yang sesuai atau tambahkan pesan sukses
        return redirect()->route('pengguna.index')->with('success', 'Data berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Periksa jika pengguna yang sedang melakukan edit adalah Admin (role_id = 1)
        // dan jika email yang diubah adalah miliknya sendiri
        if ($user->role_id === 1 && $user->id !== Auth::user()->id) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak memiliki izin untuk mengedit akun ini.');
        }

        // Validasi data pengguna yang akan diupdate
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
            'role_id' => 'required',
        ]);

        // Proses pembaruan data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $request->input('role_id');
        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_pengguna = User::findOrFail($id);

        // Pastikan pengguna yang ingin dihapus bukan admin (role_id = 1)
        if ($data_pengguna->role_id == 1) {
            return redirect()->route('pengguna.index')
                ->with('error', 'Admin tidak dapat dihapus.');
        }

        // Hapus pengguna jika dia adalah pengguna biasa (user)
        $data_pengguna->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
