<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class UserSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::paginate(10);
        return view('user.supplier.index', compact('suppliers'));
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
