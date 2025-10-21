<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Resident\ResidentController;
use App\Http\Controllers\Resident\DocumentRequestController;
use App\Http\Controllers\Resident\ComplaintController;

use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\FacilityBookingController;
use App\Http\Controllers\Staff\ResidentsController;
use App\Http\Controllers\Staff\ManageRequestController;
use App\Http\Controllers\Staff\ManageComplaintController;
use App\Http\Controllers\Staff\DocumentCreationController;
use App\Http\Controllers\Staff\ReportController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ResidentsController as AdminResidentController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\SystemSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');

/*
|--------------------------------------------------------------------------
| Dashboard Routes by Role
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // User Management
    Route::resource('users', UserController::class);

    // 🔹 AJAX Routes for Resident Search and Details
    Route::get('/residents/search', [UserController::class, 'searchResidents'])->name('residents.search');
    Route::get('/residents/{resident}/details', [UserController::class, 'details'])->name('residents.details');

    // Requests Management
    Route::get('requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('requests/{documentRequest}', [RequestController::class, 'show'])->name('requests.show');
    Route::put('requests/{documentRequest}', [RequestController::class, 'update'])->name('requests.update');

    // Complaints
    Route::resource('complaints', AdminComplaintController::class);

    // Residents Management
    Route::resource('residents', AdminResidentController::class);
    Route::post('/residents/import', [AdminResidentController::class, 'import'])->name('residents.import');

    // Officials
    Route::get('/officials/end-term', [OfficialController::class, 'endTermIndex'])->name('officials.endTerm.index');
    Route::delete('/term-ends/{id}', [OfficialController::class, 'destroyTermEnd'])->name('term_ends.destroy');
    Route::put('/officials/{official}/end-term', [OfficialController::class, 'endTerm'])->name('officials.endTerm');
    Route::resource('officials', OfficialController::class);

    // Positions Management
    Route::resource('positions', PositionController::class);

    // System Settings
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system.settings');
    Route::post('/system-settings/backup', [SystemSettingsController::class, 'backupData'])->name('system.backup');

});




/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Requests Management
    |--------------------------------------------------------------------------
    */

    Route::get('/requests', [ManageRequestController::class, 'manageRequests'])->name('requests.index');
    Route::get('/requests/create', [ManageRequestController::class, 'createWalkin'])->name('requests.create');
    Route::post('/requests', [ManageRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}', [ManageRequestController::class, 'showRequest'])->name('requests.show');
    Route::post('/requests/{id}/update-status', [ManageRequestController::class, 'updateStatus'])->name('requests.updateStatus');
    
    /*
    |--------------------------------------------------------------------------
    | Document Creation (Certificates & Permits)
    |--------------------------------------------------------------------------
    */

    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/clearance/create', [DocumentCreationController::class, 'createBarangayClearance'])
            ->name('clearance.create');
        Route::get('/residency/create', [DocumentCreationController::class, 'createResidency'])
            ->name('residency.create');
        Route::get('/indigency/create', [DocumentCreationController::class, 'createIndigency'])
            ->name('indigency.create');
    });

    Route::prefix('permits')->name('permits.')->group(function () {
        Route::get('/business/create', [DocumentCreationController::class, 'createBusinessPermit'])
            ->name('business.create');
    });

    /*
    |--------------------------------------------------------------------------
    | Complaints Management
    |--------------------------------------------------------------------------
    */

    Route::get('/complaints', [ManageComplaintController::class, 'manageComplaints'])->name('complaints.index');
    Route::get('/complaints/{id}', [ManageComplaintController::class, 'showComplaint'])->name('complaints.show');
    Route::post('/complaints/{id}/update-status', [ManageComplaintController::class, 'updateComplaintStatus'])->name('complaints.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | Facility Bookings Management
    |--------------------------------------------------------------------------
    */
    Route::get('/facility-bookings', [FacilityBookingController::class, 'index'])
        ->name('facility_bookings.index');
    Route::get('/facility-bookings/{id}', [FacilityBookingController::class, 'show'])
        ->name('facility_bookings.show');
    Route::post('/facility-bookings/{id}/approve', [FacilityBookingController::class, 'approve'])
        ->name('facility_bookings.approve');
    Route::post('/facility-bookings/{id}/reject', [FacilityBookingController::class, 'reject'])
        ->name('facility_bookings.reject');
    Route::post('/facility-bookings/{id}/update-dates', [FacilityBookingController::class, 'updateDates'])
        ->name('facility_bookings.update-dates');

    /*
    |--------------------------------------------------------------------------
    | Profiling and Residents Management
    |--------------------------------------------------------------------------
    */

    // Residents management
    Route::get('/residents', [ResidentsController::class, 'index'])->name('residents.index');
    Route::get('/residents/create', [ResidentsController::class, 'create'])->name('residents.create');
    Route::post('/residents', [ResidentsController::class, 'store'])->name('residents.store');
    Route::get('/residents/{id}', [ResidentsController::class, 'show'])->name('residents.show');

    // Bulk / utilities
    Route::post('/residents/import', [ResidentsController::class, 'importResidents'])->name('residents.import');
    Route::get('/residents/export', [ResidentsController::class, 'export'])->name('residents.export');

    // Verifications / status
    Route::post('/residents/{id}/verify', [ResidentsController::class, 'verify'])->name('residents.verify');
    Route::post('/residents/{id}/deactivate', [ResidentsController::class, 'deactivate'])->name('residents.deactivate');
    

    /*
    |--------------------------------------------------------------------------
    | Reports and Analytics
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('reports.generate');
});

/*
|--------------------------------------------------------------------------
| Resident Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:resident'])->prefix('resident')->name('resident.')->group(function () {
    // Document Requests
    Route::resource('/document-requests', DocumentRequestController::class);

    // Complaints (restricted actions)
    Route::resource('/complaints', ComplaintController::class)
        ->except(['edit', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    Route::post('/quick-update', [ProfileController::class, 'quickUpdate'])
        ->name('quickUpdate');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');



