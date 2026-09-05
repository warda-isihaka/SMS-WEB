<?php
use App\Http\Controllers\announcementcontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Models\Announcement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function(){
    Route::get('/announcements/create',
    [announcementcontroller::class,
    'create'])
    ->middleware('admin')
    ->name('announcement.store');
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

require __DIR__.'/auth.php';