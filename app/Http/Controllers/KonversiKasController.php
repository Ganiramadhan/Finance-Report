<?php

namespace App\Http\Controllers;

use App\Models\KonversiKas;
use Illuminate\Http\Request;

class KonversiKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $konversi_kas = KonversiKas::all();
        return view('admin/konversi_kas.index', compact('konversi_kas'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
