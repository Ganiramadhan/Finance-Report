<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MetodePembayaran;
use App\Models\Penjualan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::paginate(10);
        return view('user.penjualan.index', compact('penjualans'));
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
                $output .= '<td class="text-center" colspan="8">Data Penjualan tidak ditemukan.</td>';
                $output .= '</tr>';
            } else {
                foreach ($penjualan as $row) {
                    $output .= '<tr>';
                    $output .= '<td class="align-middle">' . $row->id . '</td>';
                    $output .= '<td class="align-middle">' . $row->customer->nama . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->nama . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->product->harga_jual, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->qty . '</td>';
                    $output .= '<td class="align-middle">' . 'Rp ' . number_format($row->total_harga, 0, ',', '.') . '</td>';
                    $output .= '<td class="align-middle">' . $row->product->satuan . '</td>';
                    $output .= '<td class="align-middle">' . $row->metode_pembayaran->metode_pembayaran . '</td>';
                    $output .= '<td class="align-middle">';
                    $output .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $output .= '<a href="' . route('penjualan.show', $row->id) . '" type="button" class="btn btn-secondary">';
                    $output .= '<i class="fas fa-info-circle"></i>';
                    $output .= '</a>';

                    $output .= '<form action="' . route('penjualan.destroy', $row->id) . '" method="POST" class="btn btn-danger p-0" onsubmit="return confirm(\'Apakah anda ingin menghapus data ini?\')">';
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
        return view('user/penjualan.create', compact('penjualan', 'data_customer', 'data_product', 'data_metode_pembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'harga_jual' => 'required|numeric',
            'qty' => 'required|numeric',
            'total_belanja' => 'required|numeric',
            'diskon' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'pembayaran' => 'required|numeric',
            'piutang' => 'required|numeric',
            'no_faktur' => 'required|string',
            'tanggal' => 'required|date',
            // Tambahkan validasi lain yang dibutuhkan
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::find($request->input('product_id'));

            // Periksa apakah produk tersedia
            if (!$product || $product->qty < $request->input('qty')) {
                return redirect()->back()->with('error', 'Produk tidak tersedia atau stok tidak mencukupi.');
            }

            // Periksa apakah saldo mencukupi
            $metodePembayaran = MetodePembayaran::find($request->input('metode_pembayaran_id'));
            $totalBayar = $request->input('total_bayar');

            if ($metodePembayaran && $metodePembayaran->saldo >= $totalBayar) {
                // Saldo mencukupi, lanjutkan dengan menyimpan data pembelian

                // Menghitung total harga berdasarkan harga beli satuan dan qty
                $totalHarga = $request->input('harga_jual') * $request->input('qty');

                // Menyimpan data pembelian baru ke dalam database
                Penjualan::create([
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

                // Mengurangkan saldo pada metode pembayaran
                $metodePembayaran->saldo += $totalBayar;
                $metodePembayaran->save();

                // Menambah utang pada customer
                $customer = Customer::find($request->input('customer_id'));
                $customer->saldo_awal_piutang = $request->input('piutang');
                $customer->save();

                return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
            } else {
                // Saldo tidak mencukupi, kembalikan dengan pesan kesalahan
                return redirect()->back()->with('error', 'Saldo pada metode pembayaran tidak mencukupi untuk penjualan ini.');
            }
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('user/penjualan.show', compact('penjualan'));
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


        return view('user/penjualan.edit', compact('data_product', 'data_metode_pembayaran', 'data_customer', 'penjualan', 'data_penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
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

        $penjualan = Penjualan::findOrFail($id);

        // Update the fields of the penjualan record
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

        $penjualan->save();

        // Get the related product and update its 'satuan'
        $product = Product::find($penjualan->product_id);
        if ($product) {
            $product->satuan = $request->input('satuan');
            $product->save();
        }

        // Calculate the qty change
        $previousQty = $penjualan->qty;
        $newQty = $request->input('qty');
        $qtyChange = $newQty - $previousQty;

        // Update the product's qty in the products table
        $product = Product::find($penjualan->product_id);
        $product->qty += $qtyChange;
        $product->save();

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
