<?php

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
Route::get('/', [DepanController::class,'index']);
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::middleware(['guest'])->group(function (){
    Route::post('/login', [AuthController::class, 'login']);});
    Route::get('/home', function () {return redirect('dashboard');})->name('dashboard');

    Route::middleware(['auth'])->group(function()
    {
        Route::get('dashboard',[dashboardController::class,'index'])->name('dashboard');
        Route::get('dashboard/santri',[dashboardController::class,'santri'])->middleware('userAkses:3');
        Route::get('dashboard/admin',[dashboardController::class,'admin'])->middleware('userAkses:Admin:2');
        Route::get('dashboard/superadmin',[dashboardController::class,'superadmin'])->middleware('userAkses:1');

        Route::resource('santris', santriController::class)->names(['santris' => 'santri'])->middleware('userAkses:1');
        // Route::put('/superadmin.csantri/{Id_santri}', [santriController::class, 'create'])->name('santris.create')->middleware('userAkses:1');
        
    Route::middleware('userAkses:1')->group(function () {
            // santri
          Route::get('dashboard/superadmin/data',[superadminController::class,'index'])->name('data');
          Route::get('dashboard/superadmin/create', [santriController::class, 'create'])->name('santri.create');
          Route::POST('csantri', [santriController::class, 'store'])->name('santri.store');
          Route::get('dashboard/superadmin/data',[santriController::class,'index'])->name('data');
          Route::resource('data', santriController::class);
          Route::get('/data/{Id_santri}', [santriController::class, 'show'])->name('santri.show');
          Route::get('/data/{Id_santri}/edit', [santriController::class, 'edit'])->name('santri.edit');
          Route::put('/data/{Id_santri}', [santriController::class, 'update'])->name('santri.update');
          Route::delete('/data/{Id_santri}', [santriController::class, 'destroy'])->name('santri.destroy');
            // berita
          Route::get('dashboard/superadmin/berita',[BeritaController::class,'index'])->name('berita');
          Route::resource('berita', BeritaController::class);
          Route::get('/berita',[BeritaController::class,'create'])->name('berita.create');
          Route::POST('create', [BeritaController::class, 'store'])->name('berita.store');
          Route::resource('berita', BeritaController::class);
          Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
          Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
          Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
          Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
            // profile
          Route::get('dashboard/superadmin/profile',[ProfileController::class,'index'])->name('profile');
      });
        Route::get('dashboard/superadmin/pembayaran',[superadminController::class,'bayar'])->name('pembayaran');
        Route::get('dashboard/superadmin/ajuan',[superadminController::class,'ajuan'])->name('ajuan');

        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });