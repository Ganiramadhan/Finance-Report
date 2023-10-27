<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_users = User::orderBy('name', 'asc')->get();

        return view('admin.profile.index', compact('data_users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan dengan aturan yang Anda butuhkan
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Ambil data pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('profile')) {
            // Upload gambar baru
            $profilePath = $request->file('profile')->store('profile_images', 'public');
            // Simpan path gambar baru ke dalam data pengguna
            $user->profile = 'storage/' . $profilePath;
        }

        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        // Tambahkan pembaruan data pengguna lainnya sesuai kebutuhan

        $user->save();

        // Redirect ke halaman pengguna yang diperbarui
        return redirect()->route('profile.index')->with('success', 'Profil pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
