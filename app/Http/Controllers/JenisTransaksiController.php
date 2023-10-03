<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class JenisTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_transaksi = JenisTransaksi::get();
        return view('admin/jenis_transaksi.index', compact('jenis_transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/jenis_transaksi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'jenis_transaksi' => [
                'required',
                'max:255', // Sesuaikan dengan panjang maksimum nama produk di database
                Rule::unique('jenis_transaksis', 'jenis_transaksi'), // Menambahkan kolom yang ingin divalidasi
            ],
            // ... tambahkan aturan validasi lainnya sesuai kebutuhan Anda
        ], [
            'jenis_transaksi.unique' => 'Jenis Transaksi sudah tersedia.',
        ]);
        JenisTransaksi::create($request->all());

        return redirect()->route('jenis_transaksi.index')->with('success', 'Data berhasil ditambahkan');
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
        $jenis_transaksi = JenisTransaksi::findOrFail($id);
        return view('/admin/jenis_transaksi.edit', compact('jenis_transaksi'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $request->validate([
            'jenis_transaksi' => [
                'required',
                'max:255',
                Rule::unique('jenis_transaksis')->ignore($id), // $id is the ID of the current product being edited
            ],
            // Add other validation rules as needed
        ], [
            'jenis_transaksi.unique' => 'Jenis Transaksi sudah tersedia.',
        ]);

        $jenis_transaksi = JenisTransaksi::findOrFail($id);
        $jenis_transaksi->update($request->all());


        return redirect()->route('jenis_transaksi.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenis_transaksi = JenisTransaksi::findOrFail($id);

        $jenis_transaksi->delete();

        return redirect()->route('jenis_transaksi.index')->with('success', 'Data Berhasil dihapus');
    }
}
