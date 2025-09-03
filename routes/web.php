<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProsesAuditController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\LembarKerjaController;
use App\Http\Controllers\AuditController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/password/reset', function () {
    return redirect()->route('login');
})->name('password.request');

// Tambahkan route untuk dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/updatepass', [UserController::class, 'updatePassword'])->name('user.updatepass');
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/user/profil/update', [UserController::class, 'updateProfil'])->name('user.profil.update');
    Route::post('/user/profil/updatepass', [UserController::class, 'updateProfilPass'])->name('user.profil.updatepass');

    // Proses Audit Routes
    Route::get('/proses-audit', [ProsesAuditController::class, 'index'])->name('proses-audit.index');
    Route::post('/proses-audit', [ProsesAuditController::class, 'store'])->name('proses-audit.store');
    Route::post('/proses-audit/update', [ProsesAuditController::class, 'update'])->name('proses-audit.update');
    Route::get('/proses-audit/hapus/{id}', [ProsesAuditController::class, 'destroy'])->name('proses-audit.destroy');

    // Pertanyaan Routes
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::post('/pertanyaan/update', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::get('/pertanyaan/hapus/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

    // Log Routes
    Route::get('/log', [LogController::class, 'index'])->name('log.index');
    Route::get('/log/hapus/{id}', [LogController::class, 'destroy'])->name('log.destroy');
    Route::get('/log/hapus-semua', [LogController::class, 'hapusSemua'])->name('log.hapusSemua');

    // Proyek Routes
    Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::post('/proyek', [ProyekController::class, 'store'])->name('proyek.store');
    Route::post('/proyek/update', [ProyekController::class, 'update'])->name('proyek.update');
    Route::get('/proyek/hapus/{id}', [ProyekController::class, 'destroy'])->name('proyek.destroy');
    Route::post('/proyek/proses-audit', [ProyekController::class, 'prosesAudit']);
    Route::get('/proyek/get-proses-audit/{id}', [ProyekController::class, 'getProsesAudit']);

    // Lembar Kerja Routes
    Route::get('/lembar-kerja/{id_proyek}', [LembarKerjaController::class, 'index'])->name('lembar-kerja.index');
    Route::post('/lembar-kerja/hapus-proses/{id_proyek}', [LembarKerjaController::class, 'hapusProses']);
    Route::get('/lembar-kerja/{id_proyek}/stream', [LembarKerjaController::class, 'streamPdf'])->name('lembar-kerja.stream');
    Route::get('/lembar-kerja/{id_proyek}/pdf', [LembarKerjaController::class, 'generatePdf'])->name('lembar-kerja.pdf');
    Route::post('/lembar-kerja/proses-audit', [LembarKerjaController::class, 'prosesAudit']);
    Route::get('/lembar-kerja/get-proses-audit/{id}', [LembarKerjaController::class, 'getProsesAudit']);

    // Audit routes
    Route::get('/audit/{id_proyek}/{id_proses}/{level}', [AuditController::class, 'index'])->name('audit.index');
    Route::post('/audit/{id_proyek}/{id_proses}/{level}', [AuditController::class, 'store'])->name('audit.store');
});