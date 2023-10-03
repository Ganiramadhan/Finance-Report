<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use App\Models\MetodePembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;



class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $transaksi = Transaksi::orderBy('id', 'ASC');

            if (!empty($query)) {
                $transaksi->where('kd_transaksi', 'like', '%' . $query . '%');
            }

            $transaksi = $transaksi->paginate(10); // Sesuaikan jumlah item per halaman sesuai kebutuhan Anda

            if ($transaksi->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="8">Data Transaksi tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($transaksi as $trx) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $trx->id . '</td>';
                    $output .= '<td class="align-middle">' . $trx->kd_transaksi . '</td>';
                    $output .= '<td class="align-middle">' . $trx->jenis_transaksi->jenis_transaksi . '</td>';
                    $output .= '<td class="align-middle">' . $trx->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $trx->keterangan . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($trx->jumlah, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $trx->tanggal . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('transaksi.show', $trx->id) . '" type="button" class="btn btn-secondary">';
                    $output .= '<i class="fas fa-info-circle"></i>';
                    $output .= '</a>';
                    $output .= '<a href="' . route('transaksi.edit', $trx->id) . '" type="button" class="btn btn-success">';
                    $output .= '<i class="fas fa-edit"></i>';
                    $output .= '</a>';
                    $output .= '<form action="' . route('transaksi.destroy', $trx->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Apakah anda ingin menghapus data ini?\')">';
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

            return response()->json(['data' => $output, 'pagination' => $transaksi->links()->toHtml()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jenis_transaksi = JenisTransaksi::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $transaksi = Transaksi::all();
        return view('admin/transaksi.create', compact('transaksi', 'data_jenis_transaksi', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi' => [
                'required',
                'max:255',
                Rule::unique('transaksis'), // Tambahkan aturan ini
            ],
            // ... aturan validasi lainnya
        ], [
            'kd_transaksi.unique' => 'Kode transaksi sudah digunakan.', // Pesan error kustom
        ]);

        // Mengecek apakah saldo mencukupi untuk melakukan pembayaran
        $metodePembayaran = MetodePembayaran::find($request->metode_pembayaran_id);
        if ($metodePembayaran) {
            $saldo = $metodePembayaran->saldo;
            $jumlahTransaksi = $request->jumlah + $request->biaya_adm;

            if ($saldo < $jumlahTransaksi) {
                // Saldo tidak mencukupi
                return redirect()->route('transaksi.create')
                    ->withInput()
                    ->with('error', 'Saldo tidak mencukupi untuk melakukan pembayaran ini.');
            }
        }

        // Jika semua validasi berhasil, simpan transaksi
        Transaksi::create($request->all());

        // Kurangi saldo jika jenis transaksi mengurangkan saldo
        $jenisTransaksi = JenisTransaksi::find($request->jenis_transaksi_id);
        if ($jenisTransaksi && $metodePembayaran) {
            if ($jenisTransaksi->jenis_transaksi == 'Penerimaan Piutang' || $jenisTransaksi->jenis_transaksi == 'Penerimaan Pinjaman') {
                $metodePembayaran->saldo += $request->jumlah;
            } else {
                $metodePembayaran->saldo -= $request->jumlah;
            }
            $metodePembayaran->save();
        }

        return redirect()->route('transaksi.index')->with('success', 'Data Berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('admin/transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_jenis_transaksi = JenisTransaksi::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $transaksi = Transaksi::findOrFail($id);

        return view('admin/transaksi.edit', compact('data_jenis_transaksi', 'data_metode_pembayaran', 'transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi' => [
                'required',
                'max:255',
                Rule::unique('transaksis')->ignore($id),
            ],
            // ... aturan validasi lainnya
        ], [
            'kd_transaksi.unique' => 'Kode transaksi sudah digunakan.',
        ]);

        // Temukan transaksi yang akan diupdate
        $transaksi = Transaksi::findOrFail($id);

        // Simpan jenis transaksi sebelum diupdate
        $jenisTransaksiLama = $transaksi->jenis_transaksi;
        $metodePembayaranLama = $transaksi->metode_pembayaran;

        // Simpan jumlah transaksi sebelum diupdate
        $jumlahTransaksiLama = $transaksi->jumlah;

        // Update transaksi
        $transaksi->update($request->all());

        // Periksa perubahan jenis transaksi dan saldo di tabel metode pembayaran lama
        if ($jenisTransaksiLama && $metodePembayaranLama) {
            // Kurangi saldo lama jika jenis transaksi mengurangkan saldo
            if ($jenisTransaksiLama->jenis_transaksi == 'Penerimaan Piutang' || $jenisTransaksiLama->jenis_transaksi == 'Penerimaan Pinjaman') {
                $metodePembayaranLama->saldo -= $jumlahTransaksiLama;
            } else {
                // Tambahkan saldo lama jika jenis transaksi menambahkan saldo
                $metodePembayaranLama->saldo += $jumlahTransaksiLama;
            }

            // Simpan perubahan saldo lama
            $metodePembayaranLama->save();
        }

        // Periksa jenis transaksi baru
        $jenisTransaksiBaru = JenisTransaksi::find($request->jenis_transaksi_id);

        if ($jenisTransaksiBaru) {
            // Periksa metode pembayaran baru
            $metodePembayaranBaru = MetodePembayaran::find($request->metode_pembayaran_id);

            if ($metodePembayaranBaru) {
                // Tambahkan saldo baru jika jenis transaksi adalah penerimaan pinjaman atau penerimaan piutang
                if ($jenisTransaksiBaru->jenis_transaksi == 'Penerimaan Piutang' || $jenisTransaksiBaru->jenis_transaksi == 'Penerimaan Pinjaman') {
                    $metodePembayaranBaru->saldo += $request->jumlah;
                } else {
                    // Kurangi saldo baru jika jenis transaksi mengurangkan saldo
                    $metodePembayaranBaru->saldo -= $request->jumlah;
                }
                // Validasi saldo metode pembayaran baru
                if ($metodePembayaranBaru->saldo < 0) {
                    return redirect()->route('transaksi.edit', $id)
                        ->with('error', 'Saldo metode pembayaran tidak mencukupi untuk melakukan perubahan transaksi ini.');
                }

                // Simpan perubahan saldo baru
                $metodePembayaranBaru->save();
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Data Berhasil diupdate');
    }



    /**
     * Remove the specified resource from storage.
     */

    // ...

    public function destroy($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Ambil saldo metode pembayaran yang terkait dengan transaksi ini
        $saldoMetodePembayaran = MetodePembayaran::find($transaksi->metode_pembayaran_id);

        if (!$saldoMetodePembayaran) {
            return redirect()->route('transaksi.index')->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Periksa jenis transaksi
            if ($transaksi->jenis_transaksi->jenis_transaksi == 'Penerimaan Piutang' || $transaksi->jenis_transaksi->jenis_transaksi == 'Penerimaan Pinjaman') {
                // Kurangi saldo jika jenis transaksi adalah penerimaan piutang atau pinjaman
                $saldoMetodePembayaran->saldo -= $transaksi->jumlah;
            } else {
                // Tambahkan saldo jika jenis transaksi selain penerimaan piutang atau pinjaman
                $saldoMetodePembayaran->saldo += $transaksi->jumlah;
            }

            // Simpan saldo metode pembayaran yang diperbarui
            $saldoMetodePembayaran->save();

            // Hapus transaksi
            $transaksi->delete();

            // Commit transaksi database
            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan. Transaksi gagal dihapus.');
        }
    }
}
