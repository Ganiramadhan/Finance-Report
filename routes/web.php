<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
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
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserPenjualanController;
use App\Http\Controllers\UserPiutangController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\UserSupplierController;
use App\Http\Controllers\UserTransaksiController;
use App\Http\Controllers\UserUtangController;
use App\Http\Controllers\UtangController;
use FontLib\Table\Type\name;

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
    Route::get('/product/testing', [ProductController::class, 'testing']);


    Route::resource('/admin/barang', BarangController::class);

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

    Route::resource('/admin/pengguna', PenggunaController::class);

    Route::resource('/admin/profile', ProfileController::class);


    Route::get("/product/search", [ProductController::class, 'search'])->name('product.search');
    Route::get("/customer/search", [CustomerController::class, 'search'])->name('customer.search');
    Route::get("/supplier/search", [SupplierController::class, 'search'])->name('supplier.search');
    Route::get("/transaksi/search", [TransaksiController::class, 'search'])->name('transaksi.search');
    Route::get("/pembayaran/search", [PembayaranController::class, 'search'])->name('pembayaran.search');
    Route::get("/piutang/search", [PiutangController::class, 'search'])->name('piutang.search');
    Route::get("/pembelian/search", [PembelianController::class, 'search'])->name('pembelian.search');
    Route::get("/utang/search", [UtangController::class, 'search'])->name('utang.search');
    Route::get("/penjualan/search", [PenjualanController::class, 'search'])->name('penjualan.search');


    Route::get('product/cetak_pdf', [ProductController::class, 'cetak_pdf'])->name('cetak_pdf');
    Route::get('customer/cetak_pdf', [CustomerController::class, 'cetak_pdf'])->name('cetak_pdf');
    Route::get('supplier/cetak_pdf', [SupplierController::class, 'cetak_pdf'])->name('cetak_pdf');
    Route::get('penjualan/cetak_pdf', [PenjualanController::class, 'cetak_pdf'])->name('penjualan.cetak_pdf');
    Route::get('pembelian/cetak_pdf', [PembelianController::class, 'cetak_pdf'])->name('pembelian.cetak_pdf');
    Route::get('pembayaran/cetak_pdf', [PembayaranController::class, 'cetak_pdf'])->name('pembayaran.cetak_pdf');
    Route::get('transaksi/cetak_pdf', [TransaksiController::class, 'cetak_pdf'])->name('transaksi.cetak_pdf');
    Route::get('utang/cetak_pdf', [UtangController::class, 'cetak_pdf'])->name('utang.cetak_pdf');
    Route::get('piutang/cetak_pdf', [PiutangController::class, 'cetak_pdf'])->name('piutang.cetak_pdf');



    Route::get('/filter-transaksi', 'TransaksiController@filterTransaksi')->name('filter-transaksi');








    // Route::get('/product/pdf', 'ProductController@generatePDF')->name('product.pdf');



    // Route::get('search', 'ProductController@search');
});




// untuk Selain Admin
Route::group(['middleware' => ['auth', 'checkrole:2']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/customer', [UserCustomerController::class, 'index']);
    Route::get('/user/customer/create', [UserCustomerController::class, 'create'])->name('create');
    Route::post('/user/customer/store', [UserCustomerController::class, 'store'])->name('store');
    Route::get('/user/customer/edit/{id}', [UserCustomerController::class, 'edit'])->name('edit');
    Route::put('/user/customer/update/{id}', [UserCustomerController::class, 'update'])->name('update');


    Route::delete('/user/customer/destroy/{id}', [UserCustomerController::class, 'destroy'])->name('userCustomer.destroy');


    // Route::get('/user/customer', [UserCustomerController::class, 'index']);
    // Route::get('/user/customer', [UserCustomerController::class, 'index']);




    Route::get('/user/product', [UserProductController::class, 'index']);
    Route::get('/user/supplier', [UserSupplierController::class, 'index']);
    Route::get('/user/utang', [UserUtangController::class, 'index']);
    Route::get('/user/piutang', [UserPiutangController::class, 'index']);

    Route::get('/user/penjualan', [UserPenjualanController::class, 'index'])->name('index');
    Route::get('/user/penjualan/create', [UserPenjualanController::class, 'create'])->name('create');
    Route::post('/user/penjualan/store', [UserPenjualanController::class, 'store'])->name('store');
    Route::get('/user/penjualan/show/{id}', [UserPenjualanController::class, 'show'])->name('show');
    Route::delete('/user/penjualan/destroy/{id}', [UserPenjualanController::class, 'destroy'])->name('destroy');






    // Route::put('/user/penjualan/update/{id}', [UserCustomerController::class, 'update'])->name('customer.update');
    // Route::resource('/user/product', UserProductController::class);
    // Route::resource('/user/supplier', UserSupplierController::class);
    // Route::resource('/user/utang', UserPiutangController::class);
    // Route::resource('/user/piutang', UserPiutangController::class);
    // Route::resource('/user/penjualan', UserPenjualanController::class);

    // Route::resource('/user/customer', UserCustomerController::class);

    Route::get("/user/product/search", [UserProductController::class, 'search_user'])->name('product.search_user');
    Route::get("/user/Customer/search", [UserCustomerController::class, 'search_user'])->name('customer.search_user');
    Route::get("/user/supplier/search", [UserSupplierController::class, 'search_user'])->name('supplier.search_user');
    Route::get("/user/piutang/search", [UserPiutangController::class, 'search_user'])->name('piutang.search_user');
    Route::get("/user/utang/search", [UserUtangController::class, 'search_user'])->name('utang.search_user');
    Route::get("/user/penjualan/search", [UserPenjualanController::class, 'search_user'])->name('penjualan.search_user');
    // Route::get("/transaksi/search", [UserTransaksiController::class, 'search_user'])->name('transaksi.search_user');
    // Route::get("/pembayaran/search", [UserPembayaranController::class, 'search_user'])->name('pembayaran.search_user');
    // Route::get("/pembelian/search", [UserPembelianController::class, 'search_user'])->name('pembelian.search_user');
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