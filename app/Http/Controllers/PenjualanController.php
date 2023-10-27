<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MetodePembayaran;
use App\Models\Penjualan;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //CETAK
    public function cetak_pdf(Request $request)
    {
        $data_penjualan = Penjualan::all();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Ambil data penjualan berdasarkan tanggal
        $data_penjualan = Penjualan::whereBetween('tanggal', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('admin.penjualan.cetak_pdf', ['data_penjualan' => $data_penjualan])        // Menggunakan compact() untuk mengirim data ke view
            ->setPaper('a3', 'landscape'); // Mengatur ukuran kertas menjadi "A3" dan orientasi menjadi landscape
        return $pdf->download('penjualan_pdf.pdf'); // Mengubah nama file PDF yang akan diunduh
    }


    public function index()
    {
        $penjualans = Penjualan::paginate(10);
        return view('admin.penjualan.index', compact('penjualans'));
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $penjualan = Penjualan::orderBy('id', 'ASC');

            if (!empty($query)) {
                // Sesuaikan dengan field yang ingin Anda cari, misalnya 'nama_customer'
                $penjualan->whereHas('customer', function ($q) use ($query) {
                    $q->where('nama', 'like', '%' . $query . '%');
                });
            }

            $penjualan = $penjualan->paginate(10);

            if ($penjualan->isEmpty()) {
                $output .= '<tr>';
                $output .= '<td class="text-center" colspan="12">Data Penjualan tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($penjualan as $row) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $row->id . '</td>';
                    $output .= '<td class="align-middle">' . $row->customer->nama . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->nama . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->harga_jual . '</td>';
                    $output .= '<td class="align-middle">' . $row->qty . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->satuan . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->total_harga, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->metode_pembayaran->metode_pembayaran . '</td>';
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

            return response()->json(['data' => $output, 'pagination' => $penjualan->links()->toHtml()]);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_product = Product::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $data_customer = Customer::all();
        $penjualan = Penjualan::all();
        return view('admin/penjualan.create', compact('penjualan', 'data_customer', 'data_product', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {


        return DB::transaction(function () use ($request) {
            $product = Product::find($request->input('product_id'));

            // Periksa apakah produk tersedia
            if (!$product || $product->qty < $request->input('qty')) {
                return redirect()->back()->with('error', 'Produk tidak tersedia atau stok tidak mencukupi.');
            }

            // Menghitung total harga berdasarkan harga beli satuan dan qty
            $totalHarga = $request->input('harga_jual') * $request->input('qty');

            // Menyimpan data pembelian baru ke dalam database
            $penjualan = Penjualan::create([
                'product_id' => $request->input('product_id'),
                'harga_jual' => $request->input('harga_jual'),
                'hrg_jual_satuan' => $request->input('harga_jual'),
                'qty' => $request->input('qty'),
                'total_harga' => $totalHarga,
                'metode_pembayaran_id' => $request->input('metode_pembayaran_id'),
                'customer_id' => $request->input('customer_id'),
                'total_belanja' => $request->input('total_belanja'),
                'diskon' => $request->input('diskon'),
                'total_bayar' => $request->input('total_bayar'),
                'pembayaran' => $request->input('pembayaran'),
                'piutang' => $request->input('piutang'),
                'no_faktur' => $request->input('no_faktur'),
                'tanggal' => $request->input('tanggal'),
                'hrg_jual' => $request->input('hrg_jual'),
                'hrg_beli_satuan' => $request->input('hrg_beli_satuan'),
                // Lanjutkan dengan kolom-kolom lain sesuai kebutuhan Anda
            ]);

            // Memperbarui data satuan produk jika diperlukan
            if ($product && $product->satuan !== $request->input('satuan')) {
                $product->update([
                    'satuan' => $request->input('satuan'),
                ]);
            }


            // Mengurangkan stok produk
            $product->qty -= $request->input('qty');
            $product->save();

            // Menambah utang pada customer
            $customer = Customer::find($request->input('customer_id'));
            $customer->saldo_awal_piutang = $request->input('piutang');
            $customer->save();

            // Menambah saldo metode pembayaran  
            $metodePembayaran = MetodePembayaran::find($request->input('metode_pembayaran_id'));
            $metodePembayaran->saldo += $request->input('pembayaran');
            $metodePembayaran->save();

            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('admin/penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_product = Product::all();
        $data_metode_pembayaran = MetodePembayaran::all();
        $data_customer = Customer::all();
        $data_penjualan = Penjualan::all();
        $penjualan = Penjualan::findOrFail($id);


        return view('admin/penjualan.edit', compact('data_product', 'data_metode_pembayaran', 'data_customer', 'penjualan', 'data_penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // Validasi input dari form
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|numeric',
            'total_belanja' => 'required|numeric',
            'diskon' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'pembayaran' => 'required|numeric',
            'piutang' => 'required|numeric',
            'metode_pembayaran_id' => 'required',
            'customer_id' => 'required',
            'tanggal' => 'required|date',
        ]);

        // Temukan data penjualan berdasarkan ID yang diberikan
        $penjualan = Penjualan::findOrFail($id);

        // Dapatkan nilai pembayaran sebelumnya
        $previousPayment = $penjualan->pembayaran;

        // Dapatkan ID metode pembayaran sebelum perubahan
        $previousMetodePembayaranId = $penjualan->metode_pembayaran_id;

        // Perbarui kolom-kolom pada record penjualan
        $penjualan->product_id = $request->input('product_id');
        $penjualan->qty = $request->input('qty');
        $penjualan->total_harga = $request->input('total_belanja');
        $penjualan->metode_pembayaran_id = $request->input('metode_pembayaran_id');
        $penjualan->customer_id = $request->input('customer_id');
        $penjualan->total_belanja = $request->input('total_belanja');
        $penjualan->diskon = $request->input('diskon');
        $penjualan->total_bayar = $request->input('total_bayar');
        $penjualan->pembayaran = $request->input('pembayaran');
        $penjualan->piutang = $request->input('piutang');
        $penjualan->tanggal = $request->input('tanggal');

        // Hitung perubahan pembayaran
        $paymentChange = $request->input('pembayaran') - $previousPayment;

        $penjualan->save();

        // Dapatkan produk terkait dan perbarui kolom 'satuan'
        $product = Product::find($penjualan->product_id);
        if ($product) {
            $product->satuan = $request->input('satuan');
            $product->save();
        }

        // Hitung perubahan qty
        $previousQty = $penjualan->qty;
        $newQty = $request->input('qty');
        $qtyChange = $newQty - $previousQty;

        // Perbarui qty produk di tabel produk
        $product = Product::find($penjualan->product_id);
        $product->qty += $qtyChange;
        $product->save();

        // Perbarui utang pelanggan berdasarkan perubahan pembayaran
        $customer = Customer::find($penjualan->customer_id);
        if ($customer) {
            // Jika pembayaran berkurang, tambahkan sisa utang
            if ($paymentChange < 0) {
                $customer->saldo_awal_piutang += abs($paymentChange);
            }
            // Jika pembayaran bertambah, kurangi sisa utang
            else {
                $customer->saldo_awal_piutang -= $paymentChange;
            }
            $customer->save();
        }


        // Perbarui saldo metode pembayaran
        $metodePembayaran = MetodePembayaran::find($penjualan->metode_pembayaran_id);
        if ($metodePembayaran) {
            $metodePembayaran->saldo += $paymentChange;
            $metodePembayaran->save();
        }

        // Jika metode pembayaran telah berubah
        if ($previousMetodePembayaranId != $penjualan->metode_pembayaran_id) {
            // Kurangkan saldo dari metode pembayaran sebelumnya
            $previousMetodePembayaran = MetodePembayaran::find($previousMetodePembayaranId);
            if ($previousMetodePembayaran) {
                $previousMetodePembayaran->saldo -= $previousPayment;
                $previousMetodePembayaran->save();
            }

            // Tambahkan saldo ke metode pembayaran yang baru
            $newMetodePembayaran = MetodePembayaran::find($penjualan->metode_pembayaran_id);
            if ($newMetodePembayaran) {
                $newMetodePembayaran->saldo += $request->input('pembayaran');
                $newMetodePembayaran->save();
            }
        }



        $penjualan = Penjualan::findOrFail($id);

        // Dapatkan nilai pembayaran dan metode pembayaran sebelumnya
        $previousPayment = $penjualan->pembayaran;
        $previousMetodePembayaranId = $penjualan->metode_pembayaran_id;
        $qtyChange = $request->input('qty') - $previousQty;


        // Hitung perubahan pembayaran
        $paymentChange = $request->input('pembayaran') - $previousPayment;

        // Jika metode pembayaran telah berubah
        if ($previousMetodePembayaranId != $request->input('metode_pembayaran_id')) {
            // Kurangkan saldo dari metode pembayaran sebelumnya
            $previousMetodePembayaran = MetodePembayaran::find($previousMetodePembayaranId);
            if ($previousMetodePembayaran) {
                $previousMetodePembayaran->saldo -= $previousPayment;
                $previousMetodePembayaran->save();
            }

            // Tambahkan saldo ke metode pembayaran yang baru
            $newMetodePembayaran = MetodePembayaran::find($request->input('metode_pembayaran_id'));
            if ($newMetodePembayaran) {
                $newMetodePembayaran->saldo += $request->input('pembayaran');
                $newMetodePembayaran->save();
            }
        }

        // Redirect ke halaman index penjualan dengan pesan sukses
        return redirect()->route('penjualan.index')->with('success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Temukan penjualan yang akan dihapus
        $penjualan = Penjualan::findOrFail($id);

        // Temukan metode pembayaran yang terkait dengan penjualan
        $metodePembayaran = MetodePembayaran::find($penjualan->metode_pembayaran_id);

        // Temukan customer yang terkait dengan pembelian
        $customer = Customer::find($penjualan->customer_id);

        // Temukan produk yang terkait dengan pembelian
        $product = Product::find($penjualan->product_id);

        // Kembalikan saldo di metode pembayaran
        if ($metodePembayaran) {
            $metodePembayaran->saldo -= $penjualan->pembayaran;
            $metodePembayaran->save();
        }

        // Kembalikan utang di saldo utang awal tabel customer
        if ($customer) {
            $customer->saldo_awal_piutang -= $penjualan->piutang;
            $customer->save();
        }

        // Kembalikan jumlah produk ke tabel products
        if ($product) {
            $product->qty += $penjualan->qty;
            $product->save();
        }
        // Hapus penjualan
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data Berhasil dihapus');
    }
}
