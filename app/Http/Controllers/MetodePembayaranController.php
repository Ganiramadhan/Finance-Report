<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metode_pembayaran = MetodePembayaran::get();
        return view('admin/metode_pembayaran.index', compact('metode_pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/metode_pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        MetodePembayaran::create($request->all());
        return redirect()->route('metode_pembayaran.index')->with('success', 'Data Berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $metode_pembayaran = MetodePembayaran::findOrFail($id);
        return view('admin/metode_pembayaran.show', compact('metode_pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metode_pembayaran = MetodePembayaran::findOrFail($id);
        return view('admin/metode_pembayaran.edit', compact('metode_pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $metode_pembayaran = MetodePembayaran::findOrFail($id);
        $metode_pembayaran->update($request->all());

        return redirect()->route('metode_pembayaran.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metode_pembayaran = MetodePembayaran::findOrFail($id);

        $metode_pembayaran->delete();

        return redirect()->route('metode_pembayaran.index')->with('success', 'Data Berhasil dihapus');
    }
}