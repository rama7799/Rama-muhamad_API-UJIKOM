<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\PetugasController;
use App\Http\Controllers\WEB\PeminjamController;
use App\Http\Controllers\WEB\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // CRUD Alat
    Route::get('/alat', [AdminController::class, 'indexAlat'])->name('alat.index');
    Route::post('/alat', [AdminController::class, 'storeAlat'])->name('alat.store');

    // CRUD User
    Route::get('/users', [AdminController::class, 'indexUser'])->name('user.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('user.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('user.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('user.destroy');
    // CRUD Kategori
    Route::get('/kategori', [AdminController::class, 'indexKategori'])->name('kategori.index');
    Route::get('/kategori/create', [AdminController::class, 'createKategori'])->name('kategori.create');
    Route::post('/kategori', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('kategori.edit');
    Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');
    // CRUD Alat
    Route::get('/alat', [\App\Http\Controllers\WEB\AdminController::class, 'indexAlat'])->name('alat.index');
    Route::get('/alat/create', [\App\Http\Controllers\WEB\AdminController::class, 'createAlat'])->name('alat.create');
    Route::post('/alat', [\App\Http\Controllers\WEB\AdminController::class, 'storeAlat'])->name('alat.store');
    Route::get('/alat/{id}/edit', [\App\Http\Controllers\WEB\AdminController::class, 'editAlat'])->name('alat.edit');
    Route::put('/alat/{id}', [\App\Http\Controllers\WEB\AdminController::class, 'updateAlat'])->name('alat.update');
    Route::delete('/alat/{id}', [\App\Http\Controllers\WEB\AdminController::class, 'destroyAlat'])->name('alat.destroy');

    // CRUD Peminjaman
    Route::get('/peminjaman', [\App\Http\Controllers\WEB\AdminController::class, 'indexPeminjaman'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [\App\Http\Controllers\WEB\AdminController::class, 'createPeminjaman'])->name('peminjaman.create');
    Route::post('/peminjaman', [\App\Http\Controllers\WEB\AdminController::class, 'storePeminjaman'])->name('peminjaman.store');
    Route::put('/peminjaman/{id}/status', [\App\Http\Controllers\WEB\AdminController::class, 'updateStatusPeminjaman'])->name('peminjaman.updateStatus');
    Route::delete('/peminjaman/{id}', [\App\Http\Controllers\WEB\AdminController::class, 'destroyPeminjaman'])->name('peminjaman.destroy');

    // CRUD Pengembalian
    Route::get('/pengembalian', [AdminController::class, 'indexPengembalian'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [AdminController::class, 'createPengembalian'])->name('pengembalian.create');
    Route::post('/pengembalian', [AdminController::class, 'storePengembalian'])->name('pengembalian.store');
    Route::delete('/pengembalian/{id}', [AdminController::class, 'destroyPengembalian'])->name('pengembalian.destroy');
   
});


// petugas
Route::middleware(['auth', 'role:petugas,admin'])->prefix('petugas')->name('petugas.')->group(function () {
    // Peminjaman & Persetujuan
    Route::get('/peminjaman', [PetugasController::class, 'indexPeminjaman'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/setujui', [PetugasController::class, 'setujuiPeminjaman'])->name('peminjaman.setujui');

    // Pengembalian & Denda
    Route::post('/pengembalian/{id}', [PetugasController::class, 'prosesPengembalian'])->name('pengembalian.proses');
    // Rute Tolak Peminjaman
    Route::post('/peminjaman/{id}/tolak', [PetugasController::class, 'tolakPeminjaman'])->name('peminjaman.tolak');
    // Pengembalian & Denda
    Route::post('/pengembalian/{id}', [PetugasController::class, 'prosesPengembalian'])->name('pengembalian.proses');
    Route::get('/pengembalian', [PetugasController::class, 'indexPengembalian'])->name('pengembalian.index');
    Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/cetak', [PetugasController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::patch('/peminjaman/{id}/proses', [PetugasController::class, 'prosesPeminjaman'])->name('petugas.peminjaman.proses');
    Route::post('/peminjaman/{id}/proses', [PetugasController::class, 'setujuiPeminjaman'])->name('peminjaman.proses');
});
Route::get('/dashboard', function () {
    return redirect('/petugas/peminjaman');
});

// peminjam
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    // Katalog & Pengajuan
    Route::get('/katalog', [PeminjamController::class, 'katalogAlat'])->name('katalog');
    Route::post('/peminjaman/ajukan', [PeminjamController::class, 'ajukanPeminjaman'])->name('peminjaman.ajukan');
    Route::get('/riwayat', [PeminjamController::class, 'riwayatPeminjaman'])->name('riwayat');
});

// Route Tamu (Belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [\App\Http\Controllers\WEB\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\WEB\AuthController::class, 'login']);
});

// Route Logout (Harus sudah login)
Route::post('/logout', [\App\Http\Controllers\WEB\AuthController::class, 'logout'])->name('logout')->middleware('auth');