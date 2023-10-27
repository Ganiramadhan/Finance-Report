<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function cetak_pdf(Request $request)
    {
        $data_pembayaran = Pembayaran::all();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Ambil data penjualan berdasarkan tanggal
        $data_pembayaran = Pembayaran::whereBetween('tanggal', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('admin.pembayaran.cetak_pdf', ['data_pembayaran' => $data_pembayaran])        // Menggunakan compact() untuk mengirim data ke view
            ->setPaper('a3', 'landscape'); // Mengatur ukuran kertas menjadi "A3" dan orientasi menjadi landscape
        return $pdf->download('pembayaran_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }


    public function index()
    {
        $pembayarans = Pembayaran::paginate(10);
        return view('admin.pembayaran.index', compact('pembayarans'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $pembayaran = Pembayaran::orderBy('id', 'ASC');

            if (!empty($query)) {
                $pembayaran->where('kd_pembayaran', 'like', '%' . $query . '%');
            }

            $pembayaran = $pembayaran->paginate(10); // Sesuaikan jumlah item per halaman sesuai kebutuhan Anda

            if ($pembayaran->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="9">Data Pembayaran tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($pembayaran as $bayar) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $bayar->id . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->kd_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->kategori_pengeluaran->nama_kategori . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->penerima . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->keterangan . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($bayar->jml_pembayaran, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $bayar->tanggal . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group">';
                    $output .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $output .= '<i class="fas fa-cog"></i>';
                    $output .= '</button>';
                    $output .= '<div class="dropdown-menu">';
                    $output .= '<a class="dropdown-item" href="' . route('pembayaran.show', $bayar->id) . '">';
                    $output .= '<i class="fas fa-info-circle"></i> Detail';
                    $output .= '</a>';
                    $output .= '<a class="dropdown-item" href="' . route('pembayaran.edit', $bayar->id) . '">';
                    $output .= '<i class="fas fa-edit"></i> Edit';
                    $output .= '</a>';
                    $output .= '<form action="' . route('pembayaran.destroy', $bayar->id) . '" method="POST">';
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

            return response()->json(['data' => $output, 'pagination' => $pembayaran->links()->toHtml()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $data_kategori_pengeluaran = KategoriPengeluaran::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $pembayaran = Pembayaran::all();
        return view('admin/pembayaran.create', compact('pembayaran', 'data_kategori_pengeluaran', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input sesuai kebutuhan Anda
        $request->validate([
            'kategori_pengeluaran_id' => 'required',
            'penerima' => 'required',
            'jml_pembayaran' => 'required|numeric|min:0.01', // Minimal 0.01 untuk jumlah pembayaran
            'metode_pembayaran_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required|date',
            'kd_pembayaran' => 'required|unique:pembayarans,kd_pembayaran,NULL,id,metode_pembayaran_id,' . $request->input('metode_pembayaran_id'),
        ]);

        // Ambil saldo metode pembayaran dari Request
        $saldoMetodePembayaran = MetodePembayaran::find($request->input('metode_pembayaran_id'))->saldo;

        // Ambil jumlah pembayaran dari Request
        $jumlahPembayaran = $request->input('jml_pembayaran');

        // Periksa apakah saldo mencukupi
        if ($saldoMetodePembayaran >= $jumlahPembayaran) {
            // Kurangkan saldo metode pembayaran
            $saldoMetodePembayaran -= $jumlahPembayaran;

            // Buat entri pembayaran baru
            $pembayaran = new Pembayaran([
                'kategori_pengeluaran_id' => $request->input('kategori_pengeluaran_id'),
                'penerima' => $request->input('penerima'),
                'jml_pembayaran' => $jumlahPembayaran,
                'metode_pembayaran_id' => $request->input('metode_pembayaran_id'),
                'keterangan' => $request->input('keterangan'),
                'tanggal' => $request->input('tanggal'),
                'kd_pembayaran' => $request->input('kd_pembayaran'),
            ]);

            // Simpan pembayaran
            $pembayaran->save();

            // Update saldo metode pembayaran
            MetodePembayaran::where('id', $request->input('metode_pembayaran_id'))
                ->update(['saldo' => $saldoMetodePembayaran]);

            // Redirect atau lakukan tindakan lain setelah pembayaran sukses
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan');
        } else {
            // Redirect dengan pesan kesalahan jika saldo tidak mencukupi
            return redirect()->back()->with('error', 'Saldo tidak mencukupi, silahkan pilih metode pembayaran yang lain');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        return view('admin/pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_kategori_pengeluaran = KategoriPengeluaran::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $pembayaran = Pembayaran::findOrFail($id);

        return view('admin/pembayaran.edit', compact('data_kategori_pengeluaran', 'data_metode_pembayaran', 'pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Temukan pembayaran yang akan diupdate
        $pembayaran = Pembayaran::findOrFail($id);

        // Simpan metode pembayaran lama dan jumlah pembayaran lama
        $metodePembayaranLama = $pembayaran->metode_pembayaran;
        $jumlahPembayaranLama = $pembayaran->jml_pembayaran;

        // Perbedaan antara metode pembayaran baru dan lama
        $metodePembayaranBaru = MetodePembayaran::find($request->metode_pembayaran_id);

        if ($metodePembayaranLama->id !== $metodePembayaranBaru->id) {
            // Kurangi jumlah pembayaran lama dari saldo metode pembayaran lama
            $metodePembayaranLama->saldo += $jumlahPembayaranLama;
            $metodePembayaranLama->save();

            // Tambahkan jumlah pembayaran lama ke saldo metode pembayaran baru
            $metodePembayaranBaru->saldo -= $jumlahPembayaranLama;
            $metodePembayaranBaru->save();
        }

        // Perbedaan antara jumlah baru dan jumlah lama
        $perbedaanJumlah = $request->jml_pembayaran - $jumlahPembayaranLama;

        // Validasi jika saldo metode pembayaran baru tidak mencukupi
        if ($perbedaanJumlah > $metodePembayaranBaru->saldo) {
            return redirect()->back()->with('error', 'Saldo metode pembayaran tidak mencukupi untuk pembayaran ini.');
        }
        // Tambahkan selisih jumlah ke saldo metode pembayaran yang baru
        $metodePembayaranBaru->saldo -= $perbedaanJumlah;
        $metodePembayaranBaru->save();

        // Update pembayaran
        $pembayaran->update($request->all());

        return redirect()->route('pembayaran.index')->with('success', 'Data Berhasil diupdate');
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // Ambil pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Ambil saldo metode pembayaran yang terkait dengan pembayaran ini
        $saldoMetodePembayaran = MetodePembayaran::find($pembayaran->metode_pembayaran_id);

        if (!$saldoMetodePembayaran) {
            return redirect()->route('pembayaran.index')->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Kembalikan saldo dengan menambahkan jumlah pembayaran yang dihapus
            $saldoMetodePembayaran->saldo += $pembayaran->jml_pembayaran;

            // Simpan saldo metode pembayaran yang diperbarui
            $saldoMetodePembayaran->save();

            // Hapus pembayaran
            $pembayaran->delete();

            // Commit transaksi database
            DB::commit();

            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            return redirect()->route('pembayaran.index')->with('error', 'Terjadi kesalahan. Pembayaran gagal dihapus.');
        }
    }
}