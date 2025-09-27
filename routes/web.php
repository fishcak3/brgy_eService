<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/resident/dashboard', [ResidentController::class, 'dashboard'])
        ->middleware('role:resident')
        ->name('resident.dashboard');

    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])
        ->middleware('role:staff')
        ->name('staff.dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
});

Route::middleware(['auth', 'role:resident'])->group(function () {
    // Document Requests
    Route::resource('document-requests', DocumentRequestController::class);

    // Complaints (all routes for residents)
    Route::resource('complaints', ComplaintController::class)->except(['edit', 'update', 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    // Profile Index (My Profile Page)
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    // Edit & Update Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Account Deletion
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

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
