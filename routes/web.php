<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserImportController;

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        "name" => "Bandung City View I"
    ]);
});

Route::get('/about', function () {
    return view('about', [
        "title" => "Tentang BCV I",
        "name" => "Deskripsi Bandung City View I"
    ]);
});

Route::get('/lokasi', function () {
    return view('lokasi', [
        "title" => "Lokasi",
        "name" => "Lokasi BCV I",
    ]);
});

Route::get('/kontakadmin', function () {
    return view('kontakadmin', [
        "title" => "Kontak Admin",
        "name" => "Kontak BCV I",
    ]);
});

Route::get('/kontak', function () {
    return view('kontak', [
        "title" => "Kontak",
        "name" => "Kontak BCV I",
    ]);
});

Route::middleware(['auth:sanctum', 'checkRole:warga'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard', ["title" => "Dashboard"]);
    });

    Route::get('/profilewarga', function() {
        return view('profilewarga', ["title" => "Profile Warga"]);
    });

    Route::get('/detailtagihan', function(){
        return view('tagihaniplwarga', [
            "title" => "Tagihan IPL Warga"
        ]);
    });
});

Route::middleware(['auth:sanctum', 'checkRole:admin'])->group(function () {
    Route::get('/dashboardadmin', function() {
        return view('dashboardadmin', ["title" => "Dashboard"]);
    });

    Route::get('/profileadmin', function() {
        return view('profileadmin', ["title" => "Profile Admin"]);
    });

    Route::get('/tagihanipladmin', function(){
        return view('tagihanipladmin', [
            "title" => "Lihat Tagihan IPL"
        ]);
    });

    Route::get('/tagihan', function(){
        return view('tagihan', [
            "title" => "Input Tagihan IPL"
        ]);
    });

    Route::get('/kondisi', function(){
        return view('kondisi', [
            "title" => "Kondisi Air dan Alat"
        ]);
    });

    Route::get('import', [UserImportController::class, 'showForm']);
    Route::get('download-template', [UserImportController::class, 'downloadTemplate'])->name('download.template');
    Route::post('import', [UserImportController::class, 'import'])->name('user.import');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/daftarwarga', function () {
            return view('daftarwarga', ['title' => 'Daftar Akun Warga']);
        });
    });
});

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
