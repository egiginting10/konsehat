<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RiwayatController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login User
Route::get('/home/login', [AuthController::class, 'getLogin'])->name('get.login');
Route::post('/home/login', [AuthController::class, 'loginUser'])->name('login.user');

// Login Admin atau Dokter nih disini
Route::get('/admin/login', [AuthController::class, 'getLoginAdmin'])->name('get.login.admin');
Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('login.admin');

// Register untuk User
Route::get('/home/register', [AuthController::class, 'getRegister'])->name('get.register');
Route::post('/home/register', [AuthController::class, 'registerUser'])->name('register.user');
Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('register.admin');

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
Route::get('/artikel/single/{id}', [ArtikelController::class, 'artikel'])->name('detail.artikel');

Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');
Route::get('/dokter/list', [DokterController::class, 'listDokter'])->name('dokter.list');

Route::post('/home/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::post('/dokter/chat/send', [DokterController::class, 'sendMessage'])->name('dokter.chat.send');
});

Route::middleware(['auth', 'cekrole:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('user.home');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/user', [RiwayatController::class, 'riwayatUser']);

    Route::get('/dokter/chat/{dokterId}', [DokterController::class, 'chatDokter'])->name('dokter.chat');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.user');
    Route::patch('/profil/{id}', [ProfilController::class, 'updateProfilUser'])->name('update.profil.user');
});

Route::middleware(['auth', 'cekrole:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');

    // Route Management User
    Route::post('/admin/user/tambah', [AdminController::class, 'tambahUser'])->name('admin.tambah.user');
    Route::patch('/admin/user/edit/{id}', [AdminController::class, 'updateUser'])->name('admin.update.user');
    Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete.user');

    // Route management Artikel
    Route::get('/admin/artikel', [AdminController::class, 'getArtikel'])->name('admin.artikel');

    Route::get('/admin/artikel/tambah', [AdminController::class, 'getTambahArtikel'])->name('admin.tambah.artikel');
    Route::post('/admin/artikel/tambah', [AdminController::class, 'storeArtikel'])->name('admin.store.artikel');

    Route::get('/admin/artikel/edit/{id}', [AdminController::class, 'editArtikel'])->name('admin.edit.artikel');
    Route::patch('/admin/artikel/edit/{id}', [AdminController::class, 'updateArtikel'])->name('admin.update.artikel');

    Route::delete('/admin/artikel/delete/{id}', [AdminController::class, 'deleteArtikel'])->name('admin.delete.artikel');

    // Route Daftar Dokter
    Route::get('/admin/dokter', [AdminController::class, 'getDokter'])->name('admin.dokter');
    Route::post('/admin/dokter', [AdminController::class, 'tambahDokter'])->name('admin.tambah.dokter');
    Route::patch('/admin/dokter/{id}', [AdminController::class, 'updateDokter'])->name('admin.update.dokter');
    Route::delete('/admin/dokter/{id}', [AdminController::class, 'deleteDokter'])->name('admin.delete.dokter');
});

Route::middleware(['auth', 'cekrole:dokter'])->group(function () {
    Route::get('/dashboard/dokter', [DashboardDokterController::class, 'daftarKonsultasi'])->name('dokter.index');

    Route::get('/chat/{user_id}', [DashboardDokterController::class, 'bumbleChat'])->name('dokter.get.chat');

    Route::get('/riwayat-konsultasi', [DashboardDokterController::class, 'getRiwayat'])->name('dokter.get.konsul');
    Route::post('/riwayat-konsultasi', [DashboardDokterController::class, 'riwayatKonsul'])->name('dokter.konsul');
    Route::patch('/riwayat-konsul/{id}', [DashboardDokterController::class, 'udpateRiwayat'])->name('dokter.konsul.update');
    Route::delete('/riwayat-konsul/{id}', [DashboardDokterController::class, 'deleteRiwayat'])->name('dokter.delete.konsul');

    Route::post('/konsultasi/toggle-status', [DashboardDokterController::class, 'toggleStatus'])->name('konsultasi.toggle');
});
