<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\superadminController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

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
Route::middleware(['guest'])->group(function ()
    {
    Route::post('/login', [AuthController::class, 'login']);
    });
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/home', function () {return redirect('dashboard');})->name('dashboard');

Route::middleware(['auth'])->group(function()
    {
        Route::get('dashboard',[dashboardController::class,'index']);
        Route::get('dashboard/santri',[dashboardController::class,'santri'])->middleware('userAkses:Santri');
        Route::get('dashboard/admin',[dashboardController::class,'admin'])->middleware('userAkses:Admin');
        Route::get('dashboard/superadmin',[dashboardController::class,'superadmin'])->middleware('userAkses:Super_Admin');
        Route::get('dashboard/superadmin/data',[superadminController::class,'index'])->middleware('userAkses:Super_Admin')->name('data');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });