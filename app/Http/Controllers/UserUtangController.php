<?php

namespace App\Http\Controllers;

use App\Models\Utang;
use Illuminate\Http\Request;

class UserUtangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utangs = Utang::orderBy('id', 'DESC')->paginate(10);
        return view('user.utang.index', compact('utangs'));
    }


    public function search_user(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $utang = Utang::orderBy('id', 'ASC');

            if (!empty($query)) {
                // Sesuaikan dengan field yang ingin Anda cari, misalnya 'kd_transaksi'
                $utang->whereHas('supplier', function ($q) use ($query) {
                    $q->where('nama', 'like', '%' . $query . '%');
                });
            }

            $utang = $utang->paginate(10);

            if ($utang->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="8">Data Utang tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($utang as $row) {
                    $output .= '<tr>';
                    // $output .= '<td class="align-middle">' . $row->id . '</td>';
                    $output .= '<td class="align-middle">' . $row->supplier->nama . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->jumlah_utang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->pembayaran, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->sisa_utang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->keterangan . '</td>';
                    $output .= '<td class="align-middle">' . $row->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $row->tanggal . '</td>';
                    $output .= '</div>';
                    $output .= '</td>';
                    $output .= '</tr>';
                }
            }

            return response()->json(['data' => $output, 'pagination' => $utang->links()->toHtml()]);
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
