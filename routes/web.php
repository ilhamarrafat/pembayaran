<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\tingkatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BayarController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\superadminController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\santriController;
use App\Http\Controllers\telatController;

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

Route::get('/', [DepanController::class, 'index'])->name('index');
Route::get('/berita/{slug}', [BeritaController::class, 'tampil'])->name('berita.tampil');


Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::middleware(['guest'])->group(function () {
  Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware(['auth'])->group(function () {
  Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard');
  Route::get('dashboard/santri', [dashboardController::class, 'santri'])->middleware('userAkses:3');
  Route::get('dashboard/admin', [dashboardController::class, 'admin'])->middleware('userAkses:2');
  Route::get('dashboard/superadmin', [dashboardController::class, 'superadmin'])->middleware('userAkses:1');
  Route::resource('santris', santriController::class)->names(['santris' => 'santri'])->middleware('userAkses:1');
  // Route::put('/superadmin.csantri/{Id_santri}', [santriController::class, 'create'])->name('santris.create')->middleware('userAkses:1');

  Route::middleware('userAkses:1')->group(function () {
    Route::get('dashboard/superadmin', [superadminController::class, 'index'])->name('sdashboard');
    // santri
    Route::get('dashboard/superadmin/data', [superadminController::class, 'data'])->name('data');
    Route::get('dashboard/superadmin/create', [superadminController::class, 'create'])->name('csantri.create');
    Route::post('/dashboard/superadmin/data', [superadminController::class, 'store'])->name('csantri.store');
    //kelas
    // Route::get('/superadmin/kelas', [kelasController::class, 'index'])->name('kelas');
    // Route::get('/superadmin/kelas/create', [kelasController::class, 'create'])->name('kelas.create');
    // Route::post('/superadmin/kelas/data', [kelasController::class, 'store'])->name('kelas.store');
    // //tingkat
    // Route::get('/superadmin/tingkat', [tingkatController::class, 'index'])->name('tingkat');
    // Route::get('/superadmin/tingkat/create', [tingkatController::class, 'create'])->name('tingkat.create');
    // Route::post('/superadmin/tingkat/data', [tingkatController::class, 'store'])->name('tingkat.store');
    // Route::get('/superadmin/tingkat/data', [superadminController::class, 'index'])->name('data');
    Route::resource('data', superadminController::class);
    Route::get('/data/{Id_santri}', [superadminController::class, 'show'])->name('santri.show');
    Route::get('/data/{Id_santri}/edit', [superadminController::class, 'edit'])->name('santri_edit');
    Route::put('/data/{Id_santri}', [superadminController::class, 'update'])->name('santri_update');
    Route::delete('/data/{Id_santri}', [superadminController::class, 'destroy'])->name('santri_destroy');
    Route::get('/export-pdf/{Id_santri}', [superadminController::class, 'exportPDF'])->name('exportdatapdf');

    // Route::get('/data/export', [superadminController::class, 'export'])->name('export_data_santri');
    // berita
    Route::get('dashboard/superadmin/berita', [BeritaController::class, 'index'])->name('berita');
    Route::resource('berita', BeritaController::class);
    Route::get('/superadmin/berita', [BeritaController::class, 'create'])->name('berita.create');
    Route::POST('create', [BeritaController::class, 'store'])->name('berita.store');
    Route::resource('berita', BeritaController::class);
    Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    // profile
    Route::resource('profile', ProfileController::class);
    Route::get('dashboard/superadmin/profile', [ProfileController::class, 'index'])->name('profile');
    Route::POST('create', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/superadmin/profile/{id_admin}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/superadmin/profile/{id_admin}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/superadmin/profile/{id_admin}', [ProfileController::class, 'update'])->name('profile_update');
    //pembayaran
    Route::resource('pembayaran', PaymentController::class);
    Route::get('dashboard/superadmin/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
    Route::get('/superadmin/pembayaran/create', [PaymentController::class, 'create'])->name('tagihan.create');
    Route::post('/superadmin/pembayaran', [PaymentController::class, 'store'])->name('tagihan.store');
    Route::get('/superadmin/pembayaran/{Id_tagihan}/edit', [PaymentController::class, 'edit'])->name('tagihan.edit');
    Route::put('/superadmin/pembayaran/{Id_tagihan}', [PaymentController::class, 'update'])->name('tagihan.update');
    Route::delete('/superadmin/pembayaran/{Id_tagihan}', [PaymentController::class, 'destroy'])->name('tagihan.destroy');
    Route::get('/superadmin/pembayaran/tagihan', [PaymentController::class, 'export_tagihan_santri'])->name('tagihan_export');
    //export excel
    Route::get('/superadmin/export/santri', [superadminController::class, 'export_santri'])->name('export_santri');
    Route::get('/pembayaran/export/tagihan', [PaymentController::class, 'export_tagihan'])->name('export_tagihan');
    Route::get('/downloadpdf/{id}', [PaymentController::class, 'bayarPdf'])->name('bayarPdf.pdf');

    // Route::get('/superadmin/pembayaran/{Id_tagihan}/{Id_santri}', [PaymentController::class, 'show'])->name('pembayaran.admin.show');
  });

  Route::middleware('userAkses:3')->group(function () {
    Route::get('dashboard/santri', [santriController::class, 'index'])->name('index.santri');
    Route::get('/bayar/{id}', [BayarController::class, 'index'])->name('bayar');
    Route::get('bayar/{santri}', [BayarController::class, 'lihatBayar'])->name('bayar.index');
    // Route::post('/bayar', [santriController::class, 'bayar'])->name('bayar.proses');
    // Route::get('dashboard/santri/profile', [santriController::class, 'profile'])->name('profile_santri');
    Route::get('dashboard/santri/profile', [santriController::class, 'create'])->name('profile_santri');
    Route::POST('create', [santriController::class, 'store'])->name('santri.store');
    Route::get('/santri/edit', [santriController::class, 'edit'])->name('santri.edit');
    Route::put('/santri/{id}', [santriController::class, 'update'])->name('santri.update');
    // Route untuk menyimpan tagihan
    Route::POST('/cekout', [BayarController::class, 'store'])->name('cekout');
    Route::get('/download-pdf/{id}', [BayarController::class, 'downloadPdf'])->name('download.pdf');

    // Route::get('/santri/pembayaran/', [PaymentController::class, 'showSantri']);
  });

  Route::middleware('userAkses:2')->group(function () {
    Route::get('dashboard/admin', [AdminController::class, 'index'])->name('ddashboard');
    Route::get('dashboard/admin/santri', [AdminController::class, 'data'])->name('data_santri');
    //datasantri
    Route::resource('/admin/data', AdminController::class);
    Route::get('/admin/data', [AdminController::class, 'show'])->name('santri');
    Route::get('/data/export/santri', [AdminController::class, 'export_data_santri'])->name('export_data_santri');
    Route::get('/exportPdf/{id}', [AdminController::class, 'exportPDF'])->name('export.pdf');
    //pembayaran
    Route::resource('pembayaran', AdminController::class);
    Route::get('dashboard/admin/pembayaran', [AdminController::class, 'tagihan'])->name('pembayaran_santri');
    Route::get('/admin/export/transaksi', [AdminController::class, 'export_excel'])->name('export_transaksi');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('tagihan.export');
    //profile
    Route::resource('profile', AdminController::class);
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('profile_admin');
    Route::post('/admin/profile-store/{id_admin}', [AdminController::class, 'store'])->name('profile_store_admin');
    Route::put('/admin/profile-update/{id_admin}', [AdminController::class, 'update'])->name('profile_update_admin');
    // Route::get('/admin/{id_admin}', [AdminController::class, 'show'])->name('profile.show');
    Route::get('/admin/{id_admin}/edit', [AdminController::class, 'edit'])->name('profile.edit');
    //berita_admin
    Route::get('/admin/berita', [AdminController::class, 'berita'])->name('berita_show');
  });
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
