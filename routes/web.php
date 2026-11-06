<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AduanController;
use App\Http\Controllers\PermohonanController;
use App\Models\Laporan;
use App\Models\Permohonan;

Route::get('/', function () {
    $totalAduan = Laporan::count();
    $totalPermohonan = Permohonan::count();

    return view('home', compact('totalAduan', 'totalPermohonan'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.dashboard');
    Route::put('/profil/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Aduan Publik
Route::get('/daftar-aduan', [LaporanController::class, 'index'])->name('aduan.index');
Route::get('/aduan', [LaporanController::class, 'create'])->middleware('auth')->name('aduan.create');
Route::post('/aduan', [LaporanController::class, 'store'])->middleware('auth')->name('aduan.store');
Route::get('/aduan/sukses/{ticket}', [LaporanController::class, 'success'])->middleware('auth')->name('aduan.success');

// Permohonan Informasi
Route::get('/daftar-permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
Route::get('/permohonan-informasi', [PermohonanController::class, 'create'])->middleware('auth')->name('permohonan.create');
Route::post('/permohonan-informasi', [PermohonanController::class, 'store'])->middleware('auth')->name('permohonan.store');

// Tracking Aduan
Route::get('/cek-status', [LaporanController::class, 'tracking'])->name('aduan.tracking');
Route::post('/cek-status', [LaporanController::class, 'checkTracking'])->name('aduan.tracking.check');

// Fitur Admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Daftar Kelola Aduan Admin menggunakan AduanController
        Route::get('/aduan', [AduanController::class, 'index'])->name('aduan.index');
        Route::get('/aduan/{id}', [AduanController::class, 'show'])->name('aduan.show');
        Route::patch('/aduan/{id}/sub-kategori', [AduanController::class, 'updateSubKategori'])->name('aduan.updateSubKategori');
        Route::patch('/aduan/{id}/status', [LaporanController::class, 'updateStatus'])->name('aduan.updateStatus');
        Route::post('/aduan/import', [LaporanController::class, 'importExcel'])->name('aduan.import');

        Route::patch('/permohonan/{id}/status', [PermohonanController::class, 'updateStatus'])->name('permohonan.updateStatus');
    });

require __DIR__.'/auth.php';