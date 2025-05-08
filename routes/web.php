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
use App\Http\Controllers\PlisioCallbackController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\User\UserTraderSubscriptionController;
use App\Http\Controllers\Admin\TradeOutcomeController;
use App\Http\Controllers\User\TradeHistoryController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\UserTradeController;
use App\Http\Controllers\TraderLeaderboardController;

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

//Public Trade Leaderboard Route
Route::get('/leaderboard', [TraderLeaderboardController::class, 'publicLeaderboard'])->name('leaderboard.public');

// Trader profile
Route::get('/traders/{trader}', [UserTraderController::class, 'show'])->name('trader.profile');

// Trader trades
Route::get('/traders/{trader}/trades', [UserTraderController::class, 'trades'])->name('trader.trades');

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
    });

    // Admin view trader subscribers
    Route::get('/traders/{trader}/subscribers', [TraderController::class, 'subscribers'])->name('trader.subscribers');

    // Admin user management routes
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit-role', [AdminUserController::class, 'editRole'])->name('users.editRole');
    Route::post('/users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');

    //Admin Trade Outcome Management Routes
    Route::get('/trade-outcomes', [TradeOutcomeController::class, 'index'])->name('tradeOutcomes.index');
    Route::get('/trade-outcomes/create', [TradeOutcomeController::class, 'create'])->name('tradeOutcomes.create');
    Route::post('/trade-outcomes', [TradeOutcomeController::class, 'store'])->name('tradeOutcomes.store');
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
    //Trade History Route
    Route::get('/trade-history', [TradeHistoryController::class, 'index'])->name('user.tradeHistory');

    //User Notifications Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications');
    Route::get('/notification/{id}/redirect', [NotificationController::class, 'redirect'])->name('user.notifications.redirect');


    //Trade Outcome Routes
    Route::get('/trade-outcome/{id}', [UserTradeOutcomeController::class, 'show'])->name('user.tradeOutcome.show');
    Route::get('/trade-outcomes/{id}', [UserTradeController::class, 'showOutcome'])->name('user.trade.outcome.show');
    
    //Trade Leaderboard Routes
    Route::get('/leaderboard', [TraderLeaderboardController::class, 'userLeaderboard'])->name('leaderboard.user');
    
    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//User Deposit Routes
Route::middleware(['auth', 'role:user'])->prefix('deposit')->name('user.deposit.')->group(function () {
    Route::get('/create', [DepositController::class, 'showForm'])->name('create');
    Route::post('/create', [DepositController::class, 'create'])->name('store');
    Route::get('/success/{deposit}', fn() => view('user.deposits.success'))->name('success');
    Route::get('/cancel/{deposit}', fn() => view('user.deposits.cancel'))->name('cancel');
    Route::get('/history', [DepositController::class, 'history'])->name('history');
});

// Webhook route (no auth)
Route::post('/plisio/callback', [PlisioCallbackController::class, 'handle'])->name('plisio.callback');

// User Trader Subscription routes
Route::middleware('auth')->group(function () {
    // ✅ Search traders (GET) — shows search form and results
    Route::get('/trade/search', [UserTraderSubscriptionController::class, 'searchForm'])->name('user.trade.search');

    // ✅ Show subscribe form for a trader (GET)
    Route::get('/trade/{trader}/subscribe', [UserTraderSubscriptionController::class, 'showSubscribeForm'])->name('user.trade.showSubscribeForm');

    // ✅ Subscribe to trader (POST)
    Route::post('/subscribe/{traderId}', [UserTraderSubscriptionController::class, 'subscribe'])->name('user.subscribe');

    // ✅ Unsubscribe (POST)
    Route::post('/unsubscribe/{subscriptionId}', [UserTraderSubscriptionController::class, 'unsubscribe'])->name('user.unsubscribe');

    // ✅ Update allocation (POST)
    Route::post('/update-allocation/{subscriptionId}', [UserTraderSubscriptionController::class, 'updateAllocation'])->name('user.updateAllocation');

    // ✅ Transfer funds between balances (POST)
    Route::post('/transfer-funds', [UserTraderSubscriptionController::class, 'transferFunds'])->name('user.transferFunds');
    
    //Trader management routes
    Route::get('/my-traders', [UserTraderSubscriptionController::class, 'myTraders'])->name('user.myTraders');

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
