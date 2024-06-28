<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalSampahController;
use App\Http\Controllers\KontakController;

Route::post('/auth/login', [AuthController::class, 'login']);

// Rute yang dapat diakses oleh semua pengguna yang diautentikasi
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/admin/data', [AdminController::class, 'getAdminData']);
    Route::post('/admin/schedule/edit', [JadwalSampahController::class, 'editSchedule']);
    Route::post('/admin/bills/add', [BillController::class, 'addBill']);
    Route::post('/admin/bills/update', [BillController::class, 'updateBill']);
    Route::post('/admin/daftarwarga', [UserController::class, 'registerWarga']);
    Route::post('/admin/find-name', [UserController::class, 'findName']);
    Route::post('/admin/get-meter-awal', [BillController::class, 'getMeterAwal']);
    
    Route::get('/schedule', [JadwalSampahController::class, 'getSchedule']);
    Route::post('/schedule/add', [JadwalSampahController::class, 'addSchedule']);
    Route::delete('/schedule/day', [JadwalSampahController::class, 'deleteScheduleByDay']);

    Route::get('/contacts', [KontakController::class, 'getContacts']);
    Route::post('/contacts', [KontakController::class, 'addContact']);
    Route::delete('/contacts/{id}', [KontakController::class, 'deleteContact']);
    Route::put('/contacts/{id}', [KontakController::class, 'updateContact']);

    Route::post('/bills', [BillController::class, 'getBills']);
    Route::post('/bills/by-month', [BillController::class, 'getBillByMonth']);
    Route::post('/dashboard/data', [JadwalSampahController::class, 'getDashboardData']);
    Route::get('/bills/{id}', [BillController::class, 'getBillDetails']);
    Route::post('/user/profile', [ProfileController::class, 'getProfile']);
    Route::post('/user/update', [ProfileController::class, 'updateProfile']);
});
