<?php
use App\Http\Controllers\announcementcontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Models\Announcement;
use App\Http\Controllers\PledgeController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Middleware\AdminMiddleware; // Or use Laravel Gates / Spatie Permissions

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [dashboardcontroller::class, 'index'])->name('dashboard');
ROUTE::get('/announcement', [announcementcontroller::class, 'create'])->name('announcement.create');
Route::post('/announcement', [announcementcontroller::class, 'store'])->name('announcement.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');

// Route ya kuhifadhi/usave data kwenye database (POST)
Route::post('/user-management/save', [UserManagementController::class, 'update'])->name('users.update');
});

Route::get('/budget', function () {
    return view('budget');
})->middleware(['auth'])->name('budget.index');

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
require __DIR__.'/auth.php';