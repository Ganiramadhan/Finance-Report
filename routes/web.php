<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JenisTransaksiController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\KonversiKasController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserPembayaranController;
use App\Http\Controllers\UserPembelianController;
use App\Http\Controllers\UserPenjualanController;
use App\Http\Controllers\UserPiutangController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\UserSupplierController;
use App\Http\Controllers\UserTransaksiController;
use App\Http\Controllers\UserUtangController;
use App\Http\Controllers\UtangController;
use App\Models\Piutang;

//  jika user belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'dologin']);
});

// untuk superadmin dan pegawai
Route::group(['middleware' => ['auth', 'checkrole:1,2']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/redirect', [RedirectController::class, 'cek']);
});


// untuk superadmin
Route::group(['middleware' => ['auth', 'checkrole:1']], function () {
    Route::get('/admin', [AdminController::class, 'index']);


    Route::resource('/admin/product', ProductController::class);

    Route::resource('/admin/pegawai', PegawaiController::class);

    Route::resource('/admin/customer', CustomerController::class);

    Route::resource('/admin/supplier', SupplierController::class);

    Route::resource('/admin/kategori_pengeluaran', KategoriPengeluaranController::class);

    Route::resource('/admin/metode_pembayaran', MetodePembayaranController::class);

    Route::resource('/admin/transaksi', TransaksiController::class);

    Route::resource('/admin/pembayaran', PembayaranController::class);

    Route::resource('/admin/piutang', PiutangController::class);

    Route::resource('/admin/pembelian', PembelianController::class);

    Route::resource('/admin/jenis_transaksi', JenisTransaksiController::class);

    Route::resource('/admin/transaksi', TransaksiController::class);

    Route::resource('/admin/rekening', RekeningController::class);

    Route::resource('/admin/konversi_kas', KonversiKasController::class);

    Route::resource('/admin/utang', UtangController::class);

    Route::resource('/admin/penjualan', PenjualanController::class);

    Route::get("/product/search", [ProductController::class, 'search'])->name('product.search');
    Route::get("/customer/search", [CustomerController::class, 'search'])->name('customer.search');
    Route::get("/supplier/search", [SupplierController::class, 'search'])->name('supplier.search');
    Route::get("/transaksi/search", [TransaksiController::class, 'search'])->name('transaksi.search');
    Route::get("/pembayaran/search", [PembayaranController::class, 'search'])->name('pembayaran.search');
    Route::get("/piutang/search", [PiutangController::class, 'search'])->name('piutang.search');
    Route::get("/pembelian/search", [PembelianController::class, 'search'])->name('pembelian.search');
    Route::get("/utang/search", [UtangController::class, 'search'])->name('utang.search');
    Route::get("/penjualan/search", [PenjualanController::class, 'search'])->name('penjualan.search');



    Route::get("/admin/cetak-pdf", [PDFController::class, 'generatePDF'])->name('product.cetak-pdf');






    // Route::get('/product/pdf', 'ProductController@generatePDF')->name('product.pdf');



    // Route::get('search', 'ProductController@search');
});




// untuk Selain Admin
Route::group(['middleware' => ['auth', 'checkrole:2']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/customer', [UserCustomerController::class, 'index']);
    Route::get('/user/product', [UserProductController::class, 'index']);
    Route::get('/user/supplier', [UserSupplierController::class, 'index']);
    Route::get('/user/utang', [UserUtangController::class, 'index']);
    Route::get('/user/piutang', [UserPiutangController::class, 'index']);
    Route::get('/user/penjualan', [UserPenjualanController::class, 'index']);
    // Route::resource('/user/product', UserProductController::class);
    // Route::resource('/user/supplier', UserSupplierController::class);
    // Route::resource('/user/utang', UserPiutangController::class);
    // Route::resource('/user/piutang', UserPiutangController::class);
    // Route::resource('/user/penjualan', UserPenjualanController::class);

    // Route::resource('/user/customer', UserCustomerController::class);






    Route::get("/product/search", [UserProductController::class, 'search'])->name('product.search');
    Route::get("/customer/search", [UserCustomerController::class, 'search'])->name('customer.search');
    Route::get("/supplier/search", [UserSupplierController::class, 'search'])->name('supplier.search');
    Route::get("/transaksi/search", [UserTransaksiController::class, 'search'])->name('transaksi.search');
    Route::get("/pembayaran/search", [UserPembayaranController::class, 'search'])->name('pembayaran.search');
    Route::get("/piutang/search", [UserPiutangController::class, 'search'])->name('piutang.search');
    Route::get("/pembelian/search", [UserPembelianController::class, 'search'])->name('pembelian.search');
    Route::get("/utang/search", [UserUtangController::class, 'search'])->name('utang.search');
    Route::get("/penjualan/search", [UserPenjualanController::class, 'search'])->name('penjualan.search');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     // Rute-rute yang hanya dapat diakses oleh admin
//     Route::get('/admin', 'AdminController@index');
//     // ...
// });




// Route::middleware(['auth', 'checkUserAccess'])->group(function () {
//     // Rute-rute yang hanya dapat diakses oleh admin (role_id 1)
    
//     Route::prefix('admin')->group(function () {
//         // Rute-rute admin di sini
//     });
// });