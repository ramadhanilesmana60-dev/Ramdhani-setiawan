<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{id}', [HomeController::class, 'show'])->name('artikel.detail');
Route::post('/artikel/{id}/public-like', [HomeController::class, 'publicLike'])->name('artikel.public-like');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::post('/notifikasi/{id}/baca', [DashboardController::class, 'bacaNotifikasi'])->name('notifikasi.baca');
    
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{artikel}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit')->middleware('ownership');
    Route::put('/artikel/{artikel}', [ArtikelController::class, 'update'])->name('artikel.update')->middleware('ownership');
    Route::delete('/artikel/{artikel}', [ArtikelController::class, 'destroy'])->name('artikel.destroy')->middleware('ownership');
    
    Route::post('/artikel/{id}/approve', [ArtikelController::class, 'approve'])->name('artikel.approve')->middleware('guru');
    Route::post('/artikel/{id}/cancel', [ArtikelController::class, 'cancel'])->name('artikel.cancel')->middleware('guru');
    Route::post('/artikel/{id}/comment', [ArtikelController::class, 'comment'])->name('artikel.comment');
    Route::post('/artikel/{id}/like', [ArtikelController::class, 'like'])->name('artikel.like');
    Route::delete('/komentar/{id}', [ArtikelController::class, 'deleteComment'])->name('komentar.delete');
    
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        
        Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
        Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
        Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
        Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
        Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
        Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');
        
        Route::get('/admin/komentars', [AdminController::class, 'komentars'])->name('admin.komentars');
        Route::delete('/admin/komentars/{id}', [AdminController::class, 'deleteKomentar'])->name('admin.komentars.delete');
        Route::get('/admin/likes', [AdminController::class, 'likes'])->name('admin.likes');
        Route::delete('/admin/likes/{id}', [AdminController::class, 'deleteLike'])->name('admin.likes.delete');
        Route::get('/admin/notifikasis', [AdminController::class, 'notifikasis'])->name('admin.notifikasis');
        Route::delete('/admin/notifikasis/{id}', [AdminController::class, 'deleteNotifikasi'])->name('admin.notifikasis.delete');
    });
});