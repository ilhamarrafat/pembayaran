<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
// Route::get('/home', function () {
//   return redirect('home');
// })->name('home');
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
    // santri
    Route::get('dashboard/superadmin/data', [superadminController::class, 'index'])->name('data');
    Route::get('dashboard/superadmin/create', [superadminController::class, 'create'])->name('santri.create');
    Route::POST('csantri', [superadminController::class, 'store'])->name('santri.store');
    Route::get('dashboard/superadmin/data', [superadminController::class, 'index'])->name('data');
    Route::resource('data', superadminController::class);
    Route::get('/data/{Id_santri}', [superadminController::class, 'show'])->name('santri.show');
    Route::get('/data/{Id_santri}/edit', [superadminController::class, 'edit'])->name('santri.edit');
    Route::put('/data/{Id_santri}', [superadminController::class, 'update'])->name('santri.update');
    Route::delete('/data/{Id_santri}', [superadminController::class, 'destroy'])->name('santri.destroy');
    // berita
    Route::get('dashboard/superadmin/berita', [BeritaController::class, 'index'])->name('berita');
    Route::resource('berita', BeritaController::class);
    Route::get('/berita', [BeritaController::class, 'create'])->name('berita.create');
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
    Route::get('/profile/{id_admin}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id_admin}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id_admin}', [ProfileController::class, 'update'])->name('profile.update');
    //pembayaran
    Route::get('dashboard/superadmin/pembayaran', [PaymentController::class, 'index'])->name('pembayaran');
    Route::get('/pembayaran/create', [PaymentController::class, 'create'])->name('tagihan.create');
    Route::post('/create', [PaymentController::class, 'store'])->name('tagihan.store');
    Route::get('/admin/pembayaran/{id}', [PaymentController::class, 'showAdmin'])->name('pembayaran.admin.show');
  });
  Route::middleware('userAkses:3')->group(function () {
    Route::get('dashboard/santri', [santriController::class, 'index'])->name('index');
    Route::get('/pembayaran', [santriController::class, 'pembayaran'])->name('bayar');
    Route::get('/santri/pembayaran/{Id_tagihan}', [PaymentController::class, 'showSantri']);
  });

  Route::get('dashboard/superadmin/ajuan', [superadminController::class, 'ajuan'])->name('ajuan');

  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
