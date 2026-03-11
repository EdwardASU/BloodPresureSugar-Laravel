<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Default welcome route
Route::get('/', fn() => redirect()->route('admin.login'));

// Admin: public login
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
});

use App\Livewire\Admin\BloodPressures\Index as BloodPressureIndex;
use App\Livewire\Admin\BloodSugars\Index as BloodSugarIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\Index as UserIndex;

// Admin: protected routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/blood-sugars', BloodSugarIndex::class)->name('blood-sugars.index');
    Route::get('/blood-pressures', BloodPressureIndex::class)->name('blood-pressures.index');
});
