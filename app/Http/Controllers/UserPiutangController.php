<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;

class UserPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piutangs = Piutang::orderBy('id', 'DESC')->paginate(10);
        return view('user.piutang.index', compact('piutangs'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $piutang = Piutang::orderBy('id', 'ASC');

            if (!empty($query)) {
                $piutang->whereHas('customer', function ($q) use ($query) {
                    $q->where('nama', 'like', '%' . $query . '%');
                });
            }

            $piutang = $piutang->paginate(10);

            $output = '';

            if ($piutang->isEmpty()) {
                $output = '<tr><td class="text-center" colspan="8">Data Piutang tidak ditemukan.</td></tr>';
            } else {
                foreach ($piutang as $row) {
                    $output .= '<tr>';
                    // $output .= '<td class="align-middle">' . $row->id . '</td>';
                    $output .= '<td class="align-middle">' . $row->customer->nama . '</td>';
                    $output .= '<td class="align-middle">Rp ' . number_format($row->jumlah_piutang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">Rp ' . number_format($row->sisa_piutang, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">Rp ' . number_format($row->pembayaran, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->keterangan . '</td>';
                    $output .= '<td class="align-middle">' . $row->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $row->tanggal . '</td>';
                    $output .= '</tr>';
                }
            }

            return response()->json(['data' => $output, 'pagination' => $piutang->links()->toHtml()]);
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
