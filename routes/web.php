<?php

use App\Http\Controllers\admin\AkunadminController;
use App\Http\Controllers\admin\AkunpelangganController;
use App\Http\Controllers\admin\MasterKategoriController;
use App\Http\Controllers\admin\PendapatanController;
use App\Http\Controllers\admin\PenerimaanController;
use App\Http\Controllers\admin\PesananController;
use App\Http\Controllers\admin\PrefController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\ReturController;
use App\Http\Controllers\admin\StokController;
use App\Http\Controllers\admin\TersediaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\menu\headingAppController;
use App\Http\Controllers\menu\menuController;
use App\Http\Controllers\menu\rolePenggunaController;
use App\Http\Controllers\menu\roleMenuController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// web
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/item/{slug}', [BerandaController::class, 'index'])->name('index-beranda');
Route::get('/produk/{slug}', [BerandaController::class, 'detail_produk'])->name('detail');
Route::post('/cart', [BerandaController::class, 'cart'])->name('cart');
Route::post('/login-proses-pelanggan', [BerandaController::class, 'login_proses_pelanggan'])->name('loginProsesPelanggan');
Route::get('/keranjang', [BerandaController::class, 'keranjang'])->name('keranjang');
Route::post('/delete-proses', [BerandaController::class, 'destroy'])->name('deleteItem');
Route::post('/update-keranjang-proses', [BerandaController::class, 'update_keranjang'])->name('updateKeranjang');
Route::get('/checkout-pesanan', [BerandaController::class, 'checkout'])->name('checkout');
Route::get('/whatsapp/{pesanan_id}', [BerandaController::class, 'whatsapp'])->name('whatsapp');
Route::post('/search-proses', [BerandaController::class, 'search_proses'])->name('searchProses');

Route::get('/registrasi', [BerandaController::class, 'registrasi'])->name('registrasi');
Route::post('/proses-registrasi', [BerandaController::class, 'proses_registrasi'])->name('prosesRegistrasi');

// login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-process', [LoginController::class, 'loginProcess'])->name('login-process');
});

Route::middleware(['auth'])->group(function () {
    // dahsboard
    Route::middleware(['hasRole.page:dashboard'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    // logout
    Route::get('/log-out', [LoginController::class, 'logOut'])->name('logOut');
    // heading
    Route::middleware(['hasRole.page:headingApp'])->group(function () {
        Route::get('/heading-aplikasi', [headingAppController::class, 'index'])->name('headingApp');
        Route::get('/add-heading-aplikasi', [headingAppController::class, 'create'])->name('tambahHeadingApp');
        Route::post('/process-add-heading-aplikasi', [headingAppController::class, 'store'])->name('aksiTambahHeadingApp');
        Route::get('/update-heading-aplikasi/{app_heading_id}', [headingAppController::class, 'edit'])->name('updateHeadingApp');
        Route::post('/aksi-update-heading-aplikasi/{app_heading_id}', [headingAppController::class, 'update'])->name('aksiUpdateHeadingApp');
        Route::get('/process-delete-heading-aplikasi/{app_heading_id}', [headingAppController::class, 'destroy'])->name('deleteHeadingApp');
    });
    // menu
    Route::middleware(['hasRole.page:menuApp'])->group(function () {
        Route::get('/menu-aplikasi', [menuController::class, 'index'])->name('menuApp');
        Route::get('/add-menu-aplikasi', [menuController::class, 'create'])->name('tambahMenuApp');
        Route::post('/process-add-menu-aplikasi', [menuController::class, 'store'])->name('aksiTambahMenuApp');
        Route::get('/update-menu-aplikasi/{menu_id}', [menuController::class, 'edit'])->name('updateMenuApp');
        Route::post('/aksi-update-menu-aplikasi/{menu_id}', [menuController::class, 'update'])->name('aksiUpdateMenuApp');
        Route::get('/process-delete-menu-aplikasi/{menu_id}', [menuController::class, 'destroy'])->name('deleteMenuApp');
    });
    // role
    Route::middleware(['hasRole.page:rolePengguna'])->group(function () {
        Route::get('/role-pengguna', [rolePenggunaController::class, 'index'])->name('rolePengguna');
        Route::get('/add-role-pengguna', [rolePenggunaController::class, 'create'])->name('tambahRolePengguna');
        Route::post('/process-add-role-pengguna', [rolePenggunaController::class, 'store'])->name('aksiTambahRolePengguna');
        Route::get('/update-role-pengguna/{role_id}', [rolePenggunaController::class, 'edit'])->name('updateRolePengguna');
        Route::post('/aksi-update-role-pengguna/{role_id}', [rolePenggunaController::class, 'update'])->name('aksiUpdateRolePengguna');
    });
    // menu
    Route::middleware(['hasRole.page:roleMenu'])->group(function () {
        Route::get('/role-menu', [roleMenuController::class, 'index'])->name('roleMenu');
        Route::get('/list-data-role-menu/{role_id}', [roleMenuController::class, 'listDataRoleMenu'])->name('listDataRoleMenu');
        Route::post('/add-role-menu', [roleMenuController::class, 'tambahRoleMenu'])->name('tambahRoleMenu');
    });
    // User
    Route::middleware(['hasRole.page:dataUser'])->group(function () {
        Route::get('/data-user', [UserController::class, 'index'])->name('dataUser');
        Route::get('/add-data-user', [UserController::class, 'create'])->name('tambahUser');
        Route::post('/process-add-data-user', [UserController::class, 'store'])->name('aksiTambahUser');
        Route::get('/update-data-user/{user_id}', [UserController::class, 'edit'])->name('UpdateUser');
        Route::post('/process-update-data-user/{user_id}', [UserController::class, 'update'])->name('aksiUpdateUser');
        Route::get('/process-delete-data-user/{user_id}', [UserController::class, 'destroy'])->name('deleteUser');
    });

    /* YOUR ROUTE APLICATION */
    // produk
    Route::middleware(['hasRole.page:dataProduk'])->prefix('admin')->group(function () {
        Route::get('/data-produk', [ProdukController::class, 'index'])->name('dataProduk');
        Route::get('/add-produk', [ProdukController::class, 'create'])->name('addProduk');
        Route::post('/add-proses-produk', [ProdukController::class, 'store'])->name('addProsesProduk');
        Route::get('/edit-produk/{slug}', [ProdukController::class, 'edit'])->name('updateProduk');
        Route::post('/edit-proses-produk', [ProdukController::class, 'update'])->name('editProsesProduk');
        Route::get('/delete-img-produk/{id}', [ProdukController::class, 'delete_img'])->name('hapusImage');
        Route::get('/process-delete-produk/{id}', [ProdukController::class, 'destroy'])->name('deleteProduk');

    });
    // pesanan
    Route::middleware(['hasRole.page:dataPesanan'])->prefix('admin')->group(function () {
        Route::get('/data-pesanan', [PesananController::class, 'index'])->name('dataPesanan');
        Route::get('/detail-pesanan/{pesanan_id}', [PesananController::class, 'show'])->name('detailPesanan');
        Route::get('/update-pesanan/{pesanan_id}/{status}', [PesananController::class, 'update_pesanan'])->name('stPesanan');
        Route::post('/update-pembayaran', [PesananController::class, 'update_pembayaran'])->name('updateStatusPembayaran');


    });
    // laporan pesanan
    Route::middleware(['hasRole.page:laporanPesanan'])->prefix('admin')->group(function () {
        Route::get('/data-laporan-pesanan', [PesananController::class, 'laporan'])->name('laporanPesanan');
        Route::get('/download-laporan-pesanan', [PesananController::class, 'download_laporan'])->name('downloadLaporanPesanan');

        Route::post('/search-laporan-pesanan', [PesananController::class, 'search_laporan'])->name('searchLaporan');
    });
    // akun admin
    Route::middleware(['hasRole.page:akunAdmin'])->prefix('admin')->group(function () {
        Route::get('/data-akun-admin', [AkunadminController::class, 'index'])->name('akunAdmin');
        Route::get('/add-akun-admin', [AkunadminController::class, 'create'])->name('addAkunAdmin');
        Route::post('/add-proses-akun-admin', [AkunadminController::class, 'store'])->name('addProsesAkunAdmin');
        Route::get('/edit-akun-admin/{user_id}', [AkunadminController::class, 'edit'])->name('editAkunAdmin');
        Route::post('/edit-proses-akun-admin/{user_id}', [AkunadminController::class, 'update'])->name('editProsesAkunAdmin');
        Route::get('/delete-akun-admin/{id}', [AkunadminController::class, 'destroy'])->name('deleteAkunAdmin');
    });
    // akun pelanggan
    Route::middleware(['hasRole.page:akunPelanggan'])->prefix('admin')->group(function () {
        Route::get('/data-akun-pelanggan', [AkunpelangganController::class, 'index'])->name('akunPelanggan');
        Route::get('/add-akun-pelanggan', [AkunpelangganController::class, 'create'])->name('addAkunPelanggan');
        Route::post('/add-proses-akun-pelanggan', [AkunpelangganController::class, 'store'])->name('addProsesAkunPelanggan');
        Route::get('/edit-akun-pelanggan/{user_id}', [AkunpelangganController::class, 'edit'])->name('editAkunPelanggan');
        Route::post('/edit-proses-akun-pelanggan/{user_id}', [AkunpelangganController::class, 'update'])->name('editProsesAkunPelanggan');
        Route::get('/delete-akun-pelanggan/{id}', [AkunpelangganController::class, 'destroy'])->name('deleteAkunPelanggan');
    });
    // kategori
    Route::middleware(['hasRole.page:dataKategori'])->prefix('admin')->group(function () {
        Route::get('/data-kategori', [MasterKategoriController::class, 'index'])->name('dataKategori');
        Route::get('/add-kategori', [MasterKategoriController::class, 'create'])->name('addKategori');
        Route::post('/add-proses-kategori', [MasterKategoriController::class, 'store'])->name('addProsesKategori');
        Route::get('/edit-kategori/{id}', [MasterKategoriController::class, 'edit'])->name('updateKategori');
        Route::post('/edit-proses-kategori', [MasterKategoriController::class, 'update'])->name('editProsesKategori');
        Route::get('/delete-kategori/{id}', [MasterKategoriController::class, 'destroy'])->name('deleteKategori');

    });
    // preference
    Route::middleware(['hasRole.page:dataPreference'])->prefix('admin')->group(function () {
        Route::get('/data-preference', [PrefController::class, 'index'])->name('dataPreference');
        Route::get('/edit-preference/{id}', [PrefController::class, 'edit'])->name('updateDataPreference');
        Route::post('/edit-proses-preference', [PrefController::class, 'update'])->name('editDataPreference');
    });
    // retur
    Route::middleware(['hasRole.page:returPembelian'])->prefix('admin')->group(function () {
        Route::get('/data-retur', [ReturController::class, 'index'])->name('returPembelian');
        Route::get('/add-retur', [ReturController::class, 'create'])->name('addRetur');
        Route::post('/add-proses-retur', [ReturController::class, 'store'])->name('addProsesRetur');
        Route::get('/edit-retur/{id}', [ReturController::class, 'edit'])->name('updateRetur');
        Route::post('/edit-proses-retur', [ReturController::class, 'update'])->name('editProsesRetur');
        Route::get('/delete-retur/{id}', [ReturController::class, 'destroy'])->name('deleteRetur');
        Route::post('/search-retur', [ReturController::class, 'search_retur'])->name('searchRetur');
        Route::get('/download-retur', [ReturController::class, 'download_retur'])->name('downloadRetur');
        // ajax
        Route::post('/ajax-detail-pesanan', [ReturController::class, 'show'])->name('ajaxDetailPesanan');
    });
    Route::middleware(['hasRole.page:pendapatan'])->prefix('admin')->group(function () {
        Route::get('/data-pendapatan', [PendapatanController::class, 'index'])->name('pendapatan');
    });
    Route::middleware(['hasRole.page:barangTersedia'])->prefix('admin')->group(function () {
        Route::get('/data-barang-tersedia', [TersediaController::class, 'index'])->name('barangTersedia');
    });
    Route::middleware(['hasRole.page:penerimaanBarang'])->prefix('admin')->group(function () {
        Route::get('/data-penerimaan-barang', [PenerimaanController::class, 'index'])->name('penerimaanBarang');
        Route::get('/add-data-penerimaan-barang', [PenerimaanController::class, 'create'])->name('addPenerimaanBarang');
        Route::post('/add-proses-data-penerimaan-barang', [PenerimaanController::class, 'store'])->name('addProcessPenerimaanBarang');
        Route::get('/edit-data-penerimaan-barang/{id}', [PenerimaanController::class, 'edit'])->name('updatePenerimaanBarang');
        //
        Route::get('/delete-process-data-penerimaan-barang/{id}', [PenerimaanController::class, 'destroy'])->name('deletePenerimaan');

        // ajax
        Route::post('/ajax-detail-produk', [PenerimaanController::class, 'get_detail_produk'])->name('ajaxDetailProduk');
    });
    //
    /* END YOUR ROUTE APLICATION */
});


