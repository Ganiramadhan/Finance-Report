<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MetodePembayaran;
use App\Models\Piutang;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piutangs = Piutang::orderBy('id', 'DESC')->paginate(10);
        return view('admin.piutang.index', compact('piutangs'));
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
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('piutang.edit', $row->id) . '" type="button" class="btn btn-success">';
                    $output .= '<i class="fas fa-edit"></i>';
                    $output .= '</a>';
                    $output .= '<form action="' . route('piutang.destroy', $row->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Apakah anda ingin menghapus data ini?\')">';
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

            return response()->json(['data' => $output, 'pagination' => $piutang->links()->toHtml()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_customer = Customer::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $piutang = Piutang::all();
        return view('admin/piutang.create', compact('piutang', 'data_customer', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        // Ambil saldo awal piutang dari customer yang dipilih
        $customer = Customer::find($request->customer_id);
        $saldoAwalPiutang = $customer->saldo_awal_piutang;

        // Ambil jumlah pembayaran dari permintaan
        $pembayaran = $request->pembayaran;

        // Hitung sisa piutang
        $sisaPiutang = $saldoAwalPiutang - $pembayaran;

        // Pastikan saldo tidak kurang dari nol
        $sisaPiutang = max(0, $sisaPiutang);

        // Mengganti nilai saldo_awal_piutang dengan sisa piutang
        $customer->saldo_awal_piutang = $sisaPiutang;
        $customer->save();

        // Ambil saldo awal dari tabel metode pembayaran yang dipilih
        $metodePembayaran = MetodePembayaran::find($request->metode_pembayaran_id);
        $saldoAwal = $metodePembayaran->saldo;

        // Ambil jumlah pembayaran dari permintaan
        $pembayaran = $request->pembayaran;

        // Hitung saldo baru
        $saldoBaru = $saldoAwal + $pembayaran;

        // Simpan saldo baru ke dalam tabel metode pembayaran
        $metodePembayaran->saldo = $saldoBaru;
        $metodePembayaran->save();

        // Selanjutnya, simpan data piutang ke dalam tabel piutang
        Piutang::create($request->all());
        return redirect()->route('piutang.index')->with('success', 'Data Berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $piutang = Piutang::findOrFail($id);
        return view('admin/piutang.show', compact('piutang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_customer = Customer::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $piutang = Piutang::findOrFail($id);
        return view('admin/piutang.edit', compact('data_customer', 'data_metode_pembayaran', 'piutang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $piutang = Piutang::findOrFail($id);
        $saldoAwal = $piutang->saldo_awal;

        // Perbedaan antara saldo awal dan sisa piutang baru
        $perbedaanSaldo = $saldoAwal - $request->sisa_piutang;

        // Hitung perubahan jumlah pembayaran
        $perubahanPembayaran = $request->pembayaran - $piutang->pembayaran;

        // Jika metode pembayaran berubah, kembalikan pembayaran sebelumnya ke saldo metode pembayaran yang lama
        if ($request->metode_pembayaran_id != $piutang->metode_pembayaran_id) {
            $metodePembayaranLama = MetodePembayaran::find($piutang->metode_pembayaran_id);
            $metodePembayaranLama->saldo += $piutang->pembayaran;
            $metodePembayaranLama->save();
        }

        // Update piutang
        $piutang->update($request->all());

        // Update saldo metode pembayaran baru
        $metodePembayaranBaru = MetodePembayaran::find($request->metode_pembayaran_id);
        $metodePembayaranBaru->saldo -= $request->pembayaran;
        $metodePembayaranBaru->save();

        // Update saldo customer
        $customer = Customer::find($piutang->customer_id);
        $customer->saldo_awal_piutang -= $perubahanPembayaran;
        $customer->save();

        return redirect()->route('piutang.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data piutang yang akan dihapus
        $piutang = Piutang::find($id);

        // Ambil saldo awal dari tabel metode pembayaran yang terkait dengan piutang ini
        $metodePembayaran = MetodePembayaran::find($piutang->metode_pembayaran_id);
        $saldoAwal = $metodePembayaran->saldo;

        // Ambil jumlah pembayaran dari piutang yang akan dihapus
        $pembayaran = $piutang->pembayaran;

        // Hitung saldo baru
        $saldoBaru = $saldoAwal - $pembayaran;

        // Validasi jika saldo tidak mencukupi
        if ($saldoBaru < 0) {
            return redirect()->route('piutang.index')->with('error', 'Saldo metode pembayaran tidak mencukupi.');
        }

        // Simpan saldo baru ke dalam tabel metode pembayaran
        $metodePembayaran->saldo = $saldoBaru;
        $metodePembayaran->save();

        // Ambil customer terkait dengan piutang
        $customer = Customer::find($piutang->customer_id);

        // Tambahkan saldo awal piutang ke saldo customer
        $customer->saldo_awal_piutang += $pembayaran;
        $customer->save();

        // Hapus data piutang
        $piutang->delete();

        return redirect()->route('piutang.index')->with('success', 'Data Berhasil dihapus');
    }
}
