<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pembayaran;
use App\Models\Rekening;
use App\Models\Piutang;
use App\Models\Utang;
use App\Models\Dashboard;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {


        // SALDO REKENING
        $metode_pembayaran = MetodePembayaran::all();

        // TOTAL PIUTANG
        $sisa_piutang = Piutang::sum('sisa_piutang');

        // TOTAL UTANG
        $sisa_utang = Utang::sum('sisa_utang');

        // TOTAL PENJUALAN
        $total_penjualan = Penjualan::sum('total_harga');
        // TOTAL PEMBELIAN
        $total_pembelian = Pembelian::sum('total_harga');


        // LABA KOTOR
        // Ambil data penjualan dan pembelian berdasarkan product_id
        $data_penjualan = Penjualan::groupBy('product_id')->selectRaw('product_id, SUM(total_harga) as total_penjualan')->get();
        $data_pembelian = Pembelian::groupBy('product_id')->selectRaw('product_id, SUM(total_belanja) as total_pembelian')->get();

        // Hitung total laba kotor dari semua produk
        $total_laba_kotor = 0;

        // Array untuk menyimpan data laba kotor per product_id bersama dengan nama produk
        $laba_kotor_per_product = [];

        foreach ($data_penjualan as $penjualan) {
            $product_id = $penjualan->product_id;
            $penjualan_total = $penjualan->total_penjualan;

            // Cari total pembelian untuk product_id yang sama
            $pembelian = $data_pembelian->where('product_id', $product_id)->first();
            $pembelian_total = $pembelian ? $pembelian->total_pembelian : 0;

            // Hitung laba kotor
            $laba_kotor = $penjualan_total - $pembelian_total;

            // Dapatkan nama produk berdasarkan product_id
            $nama_produk = Product::find($product_id)->nama;

            // Tambahkan data laba kotor dan nama produk ke array
            $laba_kotor_per_product[] = [
                'nama_produk' => $nama_produk,
                'laba_kotor' => $laba_kotor
            ];

            // Tambahkan laba kotor produk ini ke total laba kotor
            $total_laba_kotor += $laba_kotor;
        }



        // TOTAL PENGELUARAN
        $total_pengeluaran = Pembayaran::sum('jml_pembayaran');
        $laba_bersih = $total_laba_kotor - $total_pengeluaran;

        // CART PENJUALAN
        $data_penjualan = Penjualan::all();
        $data_product = Product::all();
        // Query untuk menghitung jumlah qty berdasarkan nama produk dan mengambil 10 data teratas
        $penjualanData = Penjualan::selectRaw('products.nama AS nama, SUM(penjualans.qty) AS total_qty')
            ->join('products', 'penjualans.product_id', '=', 'products.id')
            ->groupBy('products.nama')
            ->orderBy('total_qty', 'desc') // Menambahkan orderBy untuk mengambil data teratas
            ->take(10) // Mengambil 10 data teratas
            ->get();

        // CART PENGELUARAN
        $chart_pengeluaran = Pembayaran::selectRaw('keterangan, SUM(jml_pembayaran) as total_pembayaran')
            ->groupBy('keterangan')
            ->get();

        return view('admin.index', compact('chart_pengeluaran', 'laba_bersih', 'total_laba_kotor', 'total_penjualan', 'sisa_utang', 'sisa_piutang', 'metode_pembayaran', 'penjualanData', 'data_penjualan', 'data_product', 'total_laba_kotor', 'laba_kotor_per_product', 'total_pembelian'));
    }
}
