<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use App\Models\Supplier;
use App\Models\Utang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class UtangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cetak_pdf(Request $request)
    {
        $data_utang = Utang::all();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Ambil data penjualan berdasarkan tanggal
        $data_utang = Utang::whereBetween('tanggal', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('admin.utang.cetak_pdf', ['data_utang' => $data_utang])        // Menggunakan compact() untuk mengirim data ke view
            ->setPaper('a3', 'landscape'); // Mengatur ukuran kertas menjadi "A3" dan orientasi menjadi landscape
        return $pdf->download('utang_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }



    public function index()
    {
        $utangs = Utang::orderBy('id', 'DESC')->paginate(10);
        return view('admin.utang.index', compact('utangs'));
    }


    public function search(Request $request)
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
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<form action="' . route('utang.destroy', $row->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Apakah anda ingin menghapus data ini?\')">';
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

            return response()->json(['data' => $output, 'pagination' => $utang->links()->toHtml()]);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_supplier = Supplier::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $utang = Utang::all();
        return view('admin/utang.create', compact('utang', 'data_supplier', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil supplier yang dipilih
        $supplier = Supplier::find($request->supplier_id);

        // Ambil metode pembayaran yang dipilih
        $metodePembayaran = MetodePembayaran::find($request->metode_pembayaran_id);

        // Ambil saldo awal utang dan saldo metode pembayaran
        $saldoAwalUtang = $supplier->saldo_awal_utang;
        $saldoMetodePembayaran = $metodePembayaran->saldo;

        // Ambil jumlah pembayaran dari permintaan
        $pembayaran = $request->pembayaran;

        // Hitung sisa utang dan saldo baru metode pembayaran
        $sisaUtang = $saldoAwalUtang - $pembayaran;
        $saldoBaruMetodePembayaran = $saldoMetodePembayaran - $pembayaran;

        // Pastikan saldo awal utang tidak menjadi negatif
        // if ($sisaUtang < 0) {
        //     return redirect()->back()->with('error', 'Utang Sudah Lunas');
        // }

        // Pastikan saldo metode pembayaran tidak menjadi negatif
        if ($saldoBaruMetodePembayaran < 0) {
            return redirect()->back()->with('error', 'Saldo metode pembayaran tidak mencukupi untuk pembayaran ini.');
        }

        // Update saldo awal utang supplier
        $supplier->saldo_awal_utang = $sisaUtang;
        $supplier->save();

        // Update saldo metode pembayaran
        $metodePembayaran->saldo = $saldoBaruMetodePembayaran;
        $metodePembayaran->save();

        // Simpan data utang ke dalam tabel utang
        Utang::create($request->all());

        return redirect()->route('utang.index')->with('success', 'Data Berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $utang = Utang::findOrFail($id);
        return view('admin/utang.show', compact('utang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_supplier = Supplier::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $utang = Utang::findOrFail($id);
        return view('admin/utang.edit', compact('data_supplier', 'data_metode_pembayaran', 'utang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $utang = Utang::findOrFail($id);

        // Mengambil data supplier yang sesuai
        $supplier = Supplier::findOrFail($request->input('supplier_id'));

        $saldoAwalUtangSupplier = $supplier->saldo_awal_utang;
        $saldoAwalUtangUtang = $utang->sisa_utang;
        $pembayaranLama = $utang->pembayaran; // Simpan pembayaran sebelumnya
        $pembayaranBaru = $request->input('pembayaran');

        // Perbedaan antara pembayaran baru dan lama
        $perbedaanPembayaran = $pembayaranBaru - $pembayaranLama;

        // Jika metode pembayaran berubah, kembalikan pembayaran sebelumnya ke saldo metode pembayaran yang lama
        if ($request->input('metode_pembayaran_id') != $utang->metode_pembayaran_id) {
            $metodePembayaranLama = MetodePembayaran::findOrFail($utang->metode_pembayaran_id);
            $metodePembayaranLama->saldo += $pembayaranLama;
            $metodePembayaranLama->save();
        }

        $sisaUtang = max(0, $saldoAwalUtangSupplier + $saldoAwalUtangUtang - $pembayaranBaru);

        // Update saldo metode pembayaran yang baru
        $metodePembayaranBaru = MetodePembayaran::findOrFail($request->input('metode_pembayaran_id'));

        if ($perbedaanPembayaran > 0) {
            // Pembayaran baru lebih besar dari pembayaran lama, tambahkan selisih ke saldo metode pembayaran yang baru
            if ($perbedaanPembayaran > $metodePembayaranBaru->saldo) {
                return redirect()->route('utang.index')->with('error', 'Saldo metode pembayaran tidak mencukupi untuk pembayaran ini.');
            }
            $metodePembayaranBaru->saldo -= $perbedaanPembayaran;
        } elseif ($perbedaanPembayaran < 0) {
            // Pembayaran baru lebih kecil dari pembayaran lama, kembalikan selisih ke saldo metode pembayaran yang lama
            $metodePembayaranLama = MetodePembayaran::findOrFail($utang->metode_pembayaran_id);
            $metodePembayaranLama->saldo += abs($perbedaanPembayaran);
            $metodePembayaranLama->save();
        }

        $metodePembayaranBaru->save();

        // Update data utang
        $utang->supplier_id = $request->input('supplier_id');
        $utang->supplier->saldo_awal_utang = $sisaUtang; // Mengambil saldo awal utang dari supplier yang dipilih
        $utang->pembayaran = $pembayaranBaru;
        $utang->sisa_utang = $request->input('sisa_utang');
        $utang->keterangan = $request->input('keterangan');
        $utang->metode_pembayaran_id = $request->input('metode_pembayaran_id');
        $utang->tanggal = $request->input('tanggal');
        $utang->jumlah_utang = $request->input('jumlah_utang');
        $utang->save();

        return redirect()->route('utang.index')
            ->with('success', 'Data utang berhasil diperbarui.');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data utang yang akan dihapus
        $utang = Utang::find($id);

        // Ambil supplier terkait
        $supplier = $utang->supplier;

        // Ambil saldo awal dari tabel metode pembayaran yang terkait dengan utang ini
        $metodePembayaran = MetodePembayaran::find($utang->metode_pembayaran_id);
        $saldoMetodePembayaran = $metodePembayaran->saldo;

        // Ambil jumlah pembayaran dari utang yang akan dihapus
        $pembayaran = $utang->pembayaran;

        // Hitung saldo baru untuk supplier dan metode pembayaran
        $saldoBaruSupplier = $supplier->saldo_awal_utang + $pembayaran;
        $saldoBaruMetodePembayaran = $saldoMetodePembayaran + $pembayaran;

        // Simpan saldo baru ke dalam tabel supplier dan metode pembayaran
        $supplier->saldo_awal_utang = $saldoBaruSupplier;
        $supplier->save();

        $metodePembayaran->saldo = $saldoBaruMetodePembayaran;
        $metodePembayaran->save();

        // Hapus data utang
        $utang->delete();

        return redirect()->route('utang.index')->with('success', 'Data Berhasil dihapus');
    }
}
