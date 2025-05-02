<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Admin\TraderController;
use App\Http\Controllers\Admin\TradeLogController;

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

// Public auth routes
require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Add more admin routes here
    
    // Admin profile routes (optional - if you want to keep profile separate for admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // Admin trader management
Route::prefix('traders')->group(function () {
    Route::get('/', [TraderController::class, 'index'])->name('admin.traders.index');
    Route::get('/create', [TraderController::class, 'create'])->name('admin.traders.create');
    Route::post('/', [TraderController::class, 'store'])->name('admin.traders.store');
    Route::get('/{id}/edit', [TraderController::class, 'edit'])->name('admin.traders.edit');
    Route::patch('/{id}', [TraderController::class, 'update'])->name('admin.traders.update');
    Route::delete('/{id}', [TraderController::class, 'destroy'])->name('admin.traders.destroy');
});

// Admin trade logs
Route::get('trade-logs', [TradeLogController::class, 'index'])->name('admin.trade_logs.index');

});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', function (){return view('dashboard');})->name('dashboard');
    // Add more user routes here
    
    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Fallback for authenticated users without specific role (optional)
Route::middleware(['auth', 'verified'])->group(function () {
    // This can serve as a catch-all for authenticated users who don't have a specific role
    // Or you can redirect them to a role assignment page
    Route::get('/dashboard', function () {
        return redirect()->route('user.dashboard'); // or admin.dashboard based on your logic
    })->name('dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
