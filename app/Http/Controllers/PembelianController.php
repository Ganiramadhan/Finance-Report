<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use App\Models\Pembelian;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;




class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function cetak_pdf(Request $request)
    {
        $data_pembelian = Pembelian::all();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Ambil data penjualan berdasarkan tanggal
        $data_pembelian = Pembelian::whereBetween('tanggal', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('admin.pembelian.cetak_pdf', ['data_pembelian' => $data_pembelian])        // Menggunakan compact() untuk mengirim data ke view
            ->setPaper('a3', 'landscape'); // Mengatur ukuran kertas menjadi "A3" dan orientasi menjadi landscape
        return $pdf->download('pembelian_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }


    public function index()
    {
        $pembelians = Pembelian::paginate(5);
        return view('admin.pembelian.index', compact('pembelians'));
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $pembelian = Pembelian::orderBy('id', 'ASC');

            if (!empty($query)) {
                // Sesuaikan dengan field yang ingin Anda cari, misalnya 'kd_transaksi'
                $pembelian->where('kd_transaksi', 'like', '%' . $query . '%');
            }

            $pembelian = $pembelian->paginate(5);

            if ($pembelian->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="12">Data Pembelian tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($pembelian as $row) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $row->id . '</td>';
                    $output .= '<td class="align-middle">' . $row->kd_transaksi . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->nama . '</td>';
                    $output .= '<td class="align-middle">' . $row->qty . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->satuan . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->total_harga, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">' . $row->supplier->nama . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group">';
                    $output .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $output .= '<i class="fas fa-cog"></i>';
                    $output .= '</button>';
                    $output .= '<div class="dropdown-menu">';
                    $output .= '<a class="dropdown-item" href="' . route('pembelian.show', $row->id) . '">';
                    $output .= '<i class="fas fa-info-circle"></i> Detail';
                    $output .= '</a>';
                    $output .= '<form action="' . route('pembelian.destroy', $row->id) . '" method="POST">';
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

            return response()->json(['data' => $output, 'pagination' => $pembelian->links()->toHtml()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data_product = Product::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $data_supplier = Supplier::all();
        $pembelian = Pembelian::all();
        return view('admin/pembelian.create', compact('pembelian', 'data_supplier', 'data_product', 'data_metode_pembayaran'));
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
                Rule::unique('pembelians')->ignore($request->id), // Tambahkan aturan ini
            ],
            // ... aturan validasi lainnya
        ], [
            'kd_transaksi.unique' => 'Kode transaksi sudah digunakan.',
        ]);

        // Dapatkan metode pembayaran yang dipilih
        $metodePembayaran = MetodePembayaran::find($request->input('metode_pembayaran_id'));

        // Dapatkan total bayar dari input
        $totalBayar = $request->input('total_bayar');

        // Periksa apakah saldo mencukupi
        if ($metodePembayaran && $metodePembayaran->saldo >= $totalBayar) {
            // Saldo mencukupi, lanjutkan dengan menyimpan data pembelian

            // Mendapatkan data produk yang dipilih
            $product = Product::find($request->input('product_id'));

            // Menyimpan data pembelian baru ke dalam database
            Pembelian::create([
                'kd_transaksi' => $request->input('kd_transaksi'),
                'product_id' => $request->input('product_id'),
                'hrg_jual' => $request->input('hrg_jual'),
                'qty' => $request->input('qty'),
                'total_harga' => $request->input('total_harga'),
                'metode_pembayaran_id' => $request->input('metode_pembayaran_id'),
                'supplier_id' => $request->input('supplier_id'),
                'total_belanja' => $request->input('total_belanja'),
                'diskon' => $request->input('diskon'),
                'total_bayar' => $request->input('total_bayar'),
                'pembayaran' => $request->input('pembayaran'),
                'utang' => $request->input('utang'),
                'tanggal' => $request->input('tanggal'),
                'hrg_beli_satuan' => $request->input('hrg_beli_satuan'),
                'hrg_jual_satuan' => $request->input('hrg_jual_satuan'),
                // Lanjutkan dengan kolom-kolom lain sesuai kebutuhan Anda
            ]);

            // Memperbarui data satuan produk jika diperlukan
            if ($product && $product->satuan !== $request->input('satuan')) {
                $product->update([
                    'satuan' => $request->input('satuan'),
                ]);
            }

            $product = Product::find($request->input('product_id'));
            $product->qty += $request->input('qty');
            $product->save();

            // Lakukan pengurangan saldo pada metode pembayaran
            $metodePembayaran->saldo -= $totalBayar;
            $metodePembayaran->save();

            // Lakukan penambahan utang pada saldo awal utang di tabel supplier
            $supplier = Supplier::find($request->input('supplier_id'));
            $utang = $request->input('utang');

            if ($supplier) {
                $supplier->saldo_awal_utang = $utang;
                $supplier->save();
            }

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan.');
        } else {
            // Saldo tidak mencukupi, kembalikan dengan pesan kesalahan
            return redirect()->back()->with('error', 'Saldo pada metode pembayaran tidak mencukupi untuk pembelian ini.');
        }
    }

    public function show(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('admin/pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_product = Product::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $data_supplier = Supplier::all();
        $data_pembelian = Pembelian::all();
        $pembelian = Pembelian::findOrFail($id);


        return view('admin/pembelian.edit', compact('data_product', 'data_metode_pembayaran', 'data_supplier', 'pembelian', 'data_pembelian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kd_transaksi' => 'required|unique:pembelians,kd_transaksi,' . $id,
            'product_id' => 'required',
            'qty' => 'required|numeric',
            'total_belanja' => 'required|numeric',
            'diskon' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'pembayaran' => 'required|numeric',
            'utang' => 'required|numeric',
            'metode_pembayaran_id' => 'required',
            'supplier_id' => 'required',
            'tanggal' => 'required|date',
        ]);

        $pembelian = Pembelian::findOrFail($id);

        // Update the fields of the Pembelian record
        $pembelian->kd_transaksi = $request->input('kd_transaksi');
        $pembelian->product_id = $request->input('product_id');
        $pembelian->qty = $request->input('qty');
        $pembelian->total_harga = $request->input('total_harga');
        $pembelian->metode_pembayaran_id = $request->input('metode_pembayaran_id');
        $pembelian->supplier_id = $request->input('supplier_id');
        $pembelian->total_belanja = $request->input('total_belanja');
        $pembelian->diskon = $request->input('diskon');
        $pembelian->total_bayar = $request->input('total_bayar');
        $pembelian->pembayaran = $request->input('pembayaran');
        $pembelian->utang = $request->input('utang');
        $pembelian->tanggal = $request->input('tanggal');

        $pembelian->save();

        // Get the related product and update its 'satuan'
        $product = Product::find($pembelian->product_id);
        if ($product) {
            $product->satuan = $request->input('satuan');
            $product->save();
        }

        // Hitung perubahan qty
        $previousQty = $pembelian->qty;
        $newQty = $request->input('qty');
        $qtyChange = $newQty - $previousQty;


        // Sesuaikan jumlah produk pada tabel produk dengan perubahan qty
        $product = Product::find($pembelian->product_id);
        $product->qty += $qtyChange;
        $product->save();



        return redirect()->route('pembelian.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan pembelian yang akan dihapus
        $pembelian = Pembelian::findOrFail($id);

        // Temukan metode pembayaran yang terkait dengan pembelian
        $metodePembayaran = MetodePembayaran::find($pembelian->metode_pembayaran_id);

        // Temukan supplier yang terkait dengan pembelian
        $supplier = Supplier::find($pembelian->supplier_id);

        // Temukan produk yang terkait dengan pembelian
        $product = Product::find($pembelian->product_id);

        // Kembalikan saldo di metode pembayaran
        if ($metodePembayaran) {
            $metodePembayaran->saldo += $pembelian->pembayaran;
            $metodePembayaran->save();
        }

        // Kembalikan utang di saldo utang awal tabel supplier
        if ($supplier) {
            $supplier->saldo_awal_utang -= $pembelian->utang;
            $supplier->save();
        }

        // Kembalikan jumlah produk ke tabel products
        if ($product) {
            $product->qty -= $pembelian->qty;
            $product->save();
        }

        // Hapus pembelian
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data Berhasil dihapus');
    }
}
