<?php

use App\Http\Controllers\announcementcontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PledgeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes Group
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [dashboardcontroller::class, 'index'])->name('dashboard');

    // Announcements
    Route::get('/announcements/create', [announcementcontroller::class, 'create'])->middleware('admin')->name('announcements.create.admin');
    Route::get('/announcement', [announcementcontroller::class, 'create'])->name('announcement.create');
    Route::post('/announcement', [announcementcontroller::class, 'store'])->name('announcement.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::post('/user-management/save', [UserManagementController::class, 'store'])->name('roles.store');

    // Budget
    Route::get('/budget', function () {
        return view('budget');
    })->name('budget.index');

    // Pledges
    Route::get('/create', [PledgeController::class, 'create'])->name('create');
    Route::post('/create', [PledgeController::class, 'store'])->name('store');

    // Pledge Status
    Route::get('/status', [PledgeController::class, 'showStatus'])->name('status');
    Route::get('/status/search', [PledgeController::class, 'searchStatus'])->name('status.search');
    Route::get('/pledge_status', [PledgeController::class, 'showStatus'])->name('pledge_status');

    // Cards
Route::get('/card', [PledgeController::class, 'showCard'])->name('card.index');

    // --- PLEDGE MANAGEMENT ROUTES (MAREKEBISHO YAKO HAPA) ---
    // 1. Inaita Controller ili kuvuta $pledges kutoka DB
    Route::get('/pledge_management', [PledgeController::class, 'pledgeManagement'])->name('pledge_management.index');
    
    // 2. Inahifadhi Paid na Remain pindi unapobonyeza Update
    Route::post('/pledge/update-paid-remain', [PledgeController::class, 'updateStatusAndPaid'])->name('pledge.updateStatusAndPaid');

});

// Logout Route
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';