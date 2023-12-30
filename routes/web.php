<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PaguController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SubKegiatanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', UserController::class);
    Route::resource('/pejabat', PejabatController::class);
    Route::resource('/jabatan', JabatanController::class);
    Route::prefix('/kegiatan')->group(function () {
        Route::resource('/utama', KegiatanController::class);
        Route::resource('/sub-kegiatan', SubKegiatanController::class);
        Route::resource('/program', ProgramController::class);
    });
    Route::resource('/pagu', PaguController::class);
    Route::put('/resetpassword/{user}', [UserController::class, 'resetPasswordAdmin'])->name('resetpassword.resetPasswordAdmin');
});
