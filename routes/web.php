<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Admin\TraderController;
use App\Http\Controllers\Admin\TradeLogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\Admin\SettingsController;

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
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Add more admin routes here
    
    // Admin Profile Routes
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');


    Route::resource('traders', TraderController::class);
    // Admin trader management
    Route::prefix('traders')->group(function () {
    Route::get('/', [TraderController::class, 'index'])->name('traders.index');
    Route::get('/create', [TraderController::class, 'create'])->name('traders.create');
    Route::post('/', [TraderController::class, 'store'])->name('traders.store');
    Route::get('/{id}/edit', [TraderController::class, 'edit'])->name('traders.edit');
    Route::patch('/{id}', [TraderController::class, 'update'])->name('traders.update');
    Route::delete('/{id}', [TraderController::class, 'destroy'])->name('traders.destroy');

    // Admin user management routes
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit-role', [AdminUserController::class, 'editRole'])->name('users.editRole');
    Route::post('/users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');

});

    // Admin trade logs
    Route::resource('trade-logs', TradeLogController::class);
    Route::get('trade-logs', [TradeLogController::class, 'index'])->name('trade_logs.index');

    //Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    // Add more user routes here
    
    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:user', 'check.deposits'])
    ->prefix('deposits')
    ->group(function () {
        Route::get('/', [DepositController::class, 'index'])->name('deposit.index');
        Route::get('/create', [DepositController::class, 'create'])->name('deposit.create');
        Route::post('/store', [DepositController::class, 'store'])->name('deposit.store');
    });


//Callback route for Deposit
Route::post('/deposit-callback', [DepositController::class, 'callback'])->name('deposit.callback');


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
