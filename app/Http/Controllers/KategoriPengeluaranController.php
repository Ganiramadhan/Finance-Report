<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_pengeluaran = KategoriPengeluaran::get();
        return view('admin/kategori_pengeluaran.index', compact('kategori_pengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/kategori_pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        KategoriPengeluaran::create($request->all());
        return redirect()->route('kategori_pengeluaran.index')->with('success', 'Data Berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori_pengeluaran = KategoriPengeluaran::findOrFail($id);
        return view('admin/kategori_pengeluaran.show', compact('kategori_pengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori_pengeluaran = KategoriPengeluaran::findOrFail($id);
        return view('admin/kategori_pengeluaran.edit', compact('kategori_pengeluaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori_pengeluaran = KategoriPengeluaran::findOrFail($id);
        $kategori_pengeluaran->update($request->all());

        return redirect()->route('kategori_pengeluaran.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori_pengeluaran = KategoriPengeluaran::findOrFail($id);

        $kategori_pengeluaran->delete();

        return redirect()->route('kategori_pengeluaran.index')->with('success', 'Data Berhasil dihapus');
    }
}
