<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\LoginController;
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
Route::middleware(['guest'])->group(function ()
{
    Route::post('/login', [AuthController::class, 'login']);
});
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    Route::get('/home', function () {
        return redirect('/dashboard');
    });

    Route::middleware(['auth'])->group(function()
    {
        Route::get('/dashboard',[dashboardController::class,'index']);
        Route::get('/dashboard/dashboard.santri',[dashboardController::class,'santri'])->middleware('userAkses:santri');
        Route::get('/dashboard/dashboard.admin',[dashboardController::class,'admin'])->middleware('userAkses:admin');
        Route::get('/dashboard/dashboard.superadmin',[dashboardController::class,'superadmin'])->middleware('userAkses:superadmin');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });