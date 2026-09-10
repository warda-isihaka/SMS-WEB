<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PledgeController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnnouncementController;


Route::get('/', function () {
    return view('welcome');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcement.store');
});
// Authenticated User routes (Requires login / registration)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::post('/user-management/save', [UserManagementController::class, 'update'])->name('users.update');

    // Budget & Cards
    Route::get('/budget', function () { return view('budget'); })->name('budget.index');
    Route::get('/card', function () { return view('card'); })->name('card.index');

    // Pledges
    Route::get('/pledges/create', [PledgeController::class, 'create'])->name('pledges.create');
    Route::post('/pledges', [PledgeController::class, 'store'])->name('pledges.store');
    Route::get('/pledges/status', [PledgeController::class, 'status'])->name('pledges.status');

// Authentication routes (Laravel Breeze / Fortify)
require __DIR__ . '/auth.php';


// Route za Pledge


// Route ya kuonyesha fomu ya kuunda (create)
Route::get('/create', [PledgeController::class, 'create'])->name('create');
Route::post('/create', [PledgeController::class, 'store'])->name('store');

// Route ya kuonyesha status
Route::get('/status', [PledgeController::class, 'status'])->name('status');

Route::get('/status', function () {
    return view('status');
})->middleware(['auth'])->name('status.index');

// Route ya kufungua ukurasa wa status
Route::get('/status', [PledgeController::class, 'showStatus'])->name('status');

// Route ya kufanya utafutaji wa status kwa namba ya simu
Route::get('/status/search', [PledgeController::class, 'searchStatus'])->name('status.search');
Route::get('/card', function () {
    return view('card');
})->middleware(['auth'])->name('card.index');


Route::get('/pledge_management', function () {
    return view('pledge_management');
})->middleware(['auth'])->name('pledge_management.index');

require __DIR__.'/auth.php';

