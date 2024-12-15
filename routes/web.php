<?php

use App\Http\Controllers\admin\AdminBeasiswaController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminUsersController;
use App\Http\Controllers\users\AnnouncementController;
use App\Http\Controllers\users\BeasiswaController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Controllers\users\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('guest')->group(function () {
    // Rute untuk menampilkan form login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Rute untuk login
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Rute untuk menampilkan form registrasi
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

    // Rute untuk registrasi
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    //Rute untuk logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


//Users
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.update.image');
    Route::put('/profile/personal-info', [ProfileController::class, 'updatePersonalInfo'])->name('profile.update.personal-info');
    Route::put('/profile/ipk', [ProfileController::class, 'updateIPK'])->name('profile.update.ipk');

    // Rute untuk pengumuman
    Route::prefix('announcement')->name('announcement.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/{id}', [AnnouncementController::class, 'show'])->name('show');
    });

    //Rute untuk melihat beasiswa dan mendaftar
    Route::prefix('scholarship')->name('scholarship.')->group(function () {
        Route::get('/{id}', [BeasiswaController::class, 'show'])->name('show');
        Route::get('/{id}/apply', [BeasiswaController::class, 'create'])->name('apply');
        Route::post('/{id}/apply', [BeasiswaController::class, 'store'])->name('apply.submit');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    //Rute ke pengelolaan pengguna
    Route::resource('users', AdminUsersController::class);

    //Rute ke pengelolaan beasiswa
    Route::resource('scholarship', AdminBeasiswaController::class)->except(['show']);
    Route::get('scholarship/{id}/pendaftar', [AdminBeasiswaController::class, 'listPendaftar'])->name('scholarship.pendaftar');
    Route::put('scholarship/{id}/pendaftar/{pendaftarId}', [AdminBeasiswaController::class, 'updateStatusPendaftar'])->name('scholarship.pendaftar.update-status');
});

//Fallback (untuk menangani URL yang tidak terdaftar)
Route::fallback(function () {
    return redirect()->route('dashboard');
});

