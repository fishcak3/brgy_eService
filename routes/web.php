<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/resident/dashboard', fn() => view('userdashboard.resident.dashboard'))
        ->name('resident.dashboard')
        ->middleware('role:resident');

    Route::get('/staff/dashboard', fn() => view('userdashboard.staff.dashboard'))
        ->name('staff.dashboard')
        ->middleware('role:staff');

    Route::get('/admin/dashboard', fn() => view('userdashboard.admin.dashboard'))
        ->name('admin.dashboard')
        ->middleware('role:admin');
});


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/'); // Change to /login if you want
})->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth']);
