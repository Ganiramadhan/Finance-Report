<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::paginate(10);
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $suppliers = Supplier::orderBy('id', 'ASC');

            if (!empty($query)) {
                $suppliers->where('nama', 'like', '%' . $query . '%');
            }

            $suppliers = $suppliers->paginate(10); // Sesuaikan jumlah item per halaman sesuai kebutuhan Anda

            if ($suppliers->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="6">Supplier tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($suppliers as $supplier) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $supplier->id . '</td>';
                    $output .= '<td class="align-middle">' . $supplier->nama . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($supplier->saldo_awal_utang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $supplier->no_telepon . '</td>';
                    $output .= '<td class="align-middle">' . $supplier->alamat . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('supplier.show', $supplier->id) . '" type="button" class="btn btn-secondary">';
                    $output .= '<i class="fas fa-info-circle"></i>';
                    $output .= '</a>';
                    $output .= '<a href="' . route('supplier.edit', $supplier->id) . '" type="button" class="btn btn-success">';
                    $output .= '<i class="fas fa-edit"></i>';
                    $output .= '</a>';
                    $output .= '<form action="' . route('supplier.destroy', $supplier->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Anda yakin ingin menghapus data ini ?\')">';
                    $output .= csrf_field();
                    $output .= method_field('DELETE');
                    $output .= '<button type="submit" class="btn btn-danger m-0">';
                    $output .= '<i class="fas fa-trash"></i>';
                    $output .= '</button>';
                    $output .= '</form>';
                    $output .= '</div>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            }

            return response()->json(['data' => $output, 'pagination' => $suppliers->links()->toHtml()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/admin/supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('/admin/supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('/admin/supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Data Supplier Berhasil dihapus');
    }
}
