<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;

Route::get('/', function () {
    return view('welcome');
});

// driver
Route::get('/register/driver', [RegistrationController::class, 'showDriverForm'])->name('register.driver');
Route::post('/register/driver', [RegistrationController::class, 'storeDriver']);

// caterer
Route::get('/register/caterer', [RegistrationController::class, 'showCatererForm'])->name('register.caterer');
Route::post('/register/caterer', [RegistrationController::class, 'storeCaterer']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('redirect.role');;

    // Rute untuk Admin, dijaga oleh 'role:admin'
    Route::get('/admin/dashboard', function () {
        return '<h1>Selamat Datang di Dashboard Admin</h1>';
    })->name('admin.dashboard')->middleware('role:admin');

    // Rute untuk Katering, dijaga oleh 'role:caterer'
    Route::get('/caterer/dashboard', function () {
        return '<h1>Selamat Datang di Dashboard Katering</h1>';
    })->name('caterer.dashboard')->middleware('role:caterer');
    
    // Rute untuk Driver, dijaga oleh 'role:driver'
    Route::get('/driver/dashboard', function () {
        return '<h1>Selamat Datang di Dashboard Driver</h1>';
    })->name('driver.dashboard')->middleware('role:driver');
    
    // Rute untuk Customer/User, dijaga oleh 'role:user'
    Route::get('/home', function () {
        return '<h1>Halaman Pemilihan Makanan</h1>';
    })->name('user.dashboard')->middleware('role:user');
});
