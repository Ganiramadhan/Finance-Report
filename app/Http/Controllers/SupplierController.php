<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function cetak_pdf()
    {
        $data_supplier = Supplier::all();
        $pdf = PDF::loadView('admin.supplier.cetak_pdf', ['data_supplier' => $data_supplier]); // Menggunakan compact() untuk mengirim data ke view
        return $pdf->download('supplier_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }
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
                    $output .= '<div class="btn-group" role="group">';
                    $output .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $output .= '<i class="fas fa-cog"></i>';
                    $output .= '</button>';
                    $output .= '<div class="dropdown-menu">';
                    $output .= '<a class="dropdown-item" href="' . route('supplier.show', $supplier->id) . '">';
                    $output .= '<i class="fas fa-info-circle"></i> Detail';
                    $output .= '</a>';
                    $output .= '<a class="dropdown-item" href="' . route('supplier.edit', $supplier->id) . '">';
                    $output .= '<i class="fas fa-edit"></i> Edit';
                    $output .= '</a>';
                    $output .= '<form action="' . route('supplier.destroy', $supplier->id) . '" method="POST">';
                    $output .= csrf_field();
                    $output .= method_field('DELETE');
                    $output .= '<button type="submit" class="dropdown-item" onclick="return confirm(\'Anda yakin ingin menghapus data ini ?\')">';
                    $output .= '<i class="fas fa-trash"></i> Hapus';
                    $output .= '</button>';
                    $output .= '</form>';
                    $output .= '</div>';
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
