<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\PlisioCallbackController;
use App\Http\Controllers\TraderCompareController;
use App\Http\Controllers\TraderLeaderboardController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserTradeController;
use App\Http\Controllers\User\UserReportController;
use App\Http\Controllers\User\UserReferralController;
use App\Http\Controllers\User\UserActivityLogController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\TradeHistoryController;
use App\Http\Controllers\User\UserTraderSubscriptionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\TraderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\TradeLogController;
use App\Http\Controllers\Admin\TradeOutcomeController;
use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\AdminReferralController;
use App\Http\Controllers\Admin\ThemeSettingsController;
use App\Http\Controllers\Guest\MarketController;
use App\Http\Controllers\Guest\HelpCenterController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\User\UserWalletController;
use App\Http\Controllers\User\UserWithdrawalController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\User\UserKycController;
use App\Http\Controllers\User\UserSecurityController;
use App\Http\Controllers\Admin\AdminKycController;
use App\Http\Controllers\User\UserPreferencesController;
use App\Http\Controllers\User\UserAccountController;
use App\Http\Controllers\Admin\UserFundsController;



// Public Routes
// Theme Toggle
Route::post('/toggle-theme', [ThemeController::class, 'toggle'])->name('toggle.theme');

Route::get('/', [GuestPageController::class, 'home'])->name('home');
Route::view('/about', 'guests.about')->name('about');
Route::get('/help-center', [HelpCenterController::class, 'index'])->name('faq.index');
Route::get('/help-center/{slug}', [HelpCenterController::class, 'category'])->name('faq.category');
Route::get('/tools', function () { return view('guests.tools');})->name('tools');
Route::get('/markets', [MarketController::class, 'index'])->name('guests.markets');

Route::get('/help/{category}', [HelpCenterController::class, 'show'])->name('help.category');



// Public Leaderboard & Trader Profile
Route::get('/leaderboard', [TraderLeaderboardController::class, 'publicLeaderboard'])->name('leaderboard.public');
Route::get('/traders/{trader}', [UserTradeController::class, 'profile'])->name('guests.trader-profile');
Route::get('/traders/{trader}/trades', [UserTradeController::class, 'trades'])->name('guests.trader-trades');

//QR CODE
Route::get('/qr-code', [QrCodeController::class, 'show'])->name('qr.generate');



// Auth Routes
require __DIR__ . '/auth.php';

// ------------------------
// Admin Routes
// ------------------------
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Trader Management
    Route::resource('traders', TraderController::class);
    Route::get('traders/{trader}/subscribers', [TraderController::class, 'subscribers'])->name('trader.subscribers');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit-role', [AdminUserController::class, 'editRole'])->name('users.editRole');
    Route::post('users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::post('/users/{user}/funds', [UserFundsController::class, 'store'])->name('users.funds.store');

    // Trade Outcomes
    Route::resource('trade-outcomes', TradeOutcomeController::class)->only(['index', 'create', 'store']);
    Route::get('trades', [TradeOutcomeController::class, 'create'])->name('trades.create');

    // Trade Logs
    Route::resource('trade-logs', TradeLogController::class)->only(['index', 'store', 'create', 'show']);
    Route::get('trade-logs', [TradeLogController::class, 'index'])->name('trade_logs.index');

    // Activity Logs
    Route::get('activity-logs', [AdminActivityLogController::class, 'index'])->name('activityLogs');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('site-settings/referral', [SiteSettingsController::class, 'referralSettings'])->name('site_settings.referral');
    Route::post('site-settings/referral', [SiteSettingsController::class, 'updateReferralSettings'])->name('site_settings.referral.update');

    // Referrals
    Route::get('referrals', [AdminReferralController::class, 'index'])->name('referrals.index');
    Route::post('referrals/{referral}/approve', [AdminReferralController::class, 'approve'])->name('referrals.approve');

    // Theme Settings
    Route::get('theme-settings', [ThemeSettingsController::class, 'index'])->name('theme.settings');
    Route::post('theme-settings', [ThemeSettingsController::class, 'update'])->name('theme.settings.update');

    //Faq Routes
    Route::resource('faqs', FaqController::class);
    Route::resource('faq-categories', FaqCategoryController::class);

    //User Wallets
    Route::get('admin/user-wallets', [AdminWalletController::class, 'index'])->name('wallets.index');

    //Withdrawals
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::put('/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'update'])->name('withdrawals.update');

    Route::get('/withdrawal-settings', [AdminWithdrawalSettingsController::class, 'index'])->name('withdrawal-settings.index');
    Route::post('/withdrawal-settings', [AdminWithdrawalSettingsController::class, 'store'])->name('withdrawal-settings.store');

    //KYC Routes
    Route::get('/kyc', [AdminKycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/{kyc}', [AdminKycController::class, 'show'])->name('kyc.show');
    Route::post('/kyc/{kyc}/approve', [AdminKycController::class, 'approve'])->name('kyc.approve');
    Route::post('/kyc/{kyc}/reject', [AdminKycController::class, 'reject'])->name('kyc.reject');
});

// ------------------------
// User Routes
// ------------------------
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Trade
    Route::get('/trade-history', [TradeHistoryController::class, 'index'])->name('tradeHistory');
    Route::get('/trade-outcomes/{id}', [UserTradeController::class, 'showOutcome'])->name('trade.outcome.show');
    Route::get('/trader-profile/{trader}', [UserTradeController::class, 'profile'])->name('trader-profile');

    // Leaderboard
    Route::get('/leaderboard', [UserTradeController::class, 'leaderboard'])->name('leaderboard');

    // Trader Compare
    Route::get('/traders/compare', [UserTradeController::class, 'compare'])->name('traders.compare');
    Route::post('/trader/{trader}/add-to-compare', [UserTradeController::class, 'addToCompare'])->name('traders.addToCompare');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notification/{id}/redirect', [NotificationController::class, 'redirect'])->name('notifications.redirect');

    // Activity Logs
    Route::get('/activity-logs', [UserActivityLogController::class, 'index'])->name('activityLogs');

    // Referrals
    Route::get('/referrals', [UserReferralController::class, 'index'])->name('referrals.index');

    //Wallets
    Route::get('wallets', [UserWalletController::class, 'index'])->name('wallets.index');
    Route::post('wallets', [UserWalletController::class, 'store'])->name('wallets.store');
    Route::put('wallets/{wallet}', [UserWalletController::class, 'update'])->name('wallets.update');
    Route::delete('wallets/{wallet}', [UserWalletController::class, 'destroy'])->name('wallets.destroy');

    // Reports
    Route::get('reports', [UserReportController::class, 'showReportOptions'])->name('reports.index');
    Route::post('reports/generate', [UserReportController::class, 'generateReport'])->name('reports.generate');

    //Withdrawals
    Route::get('/withdrawals/create', [UserWithdrawalController::class, 'create'])->name('withdrawals.create');
    Route::get('/withdrawals/history', [UserWithdrawalController::class, 'history'])->name('withdrawals.history');
    Route::post('/withdrawals', [UserWithdrawalController::class, 'store'])->name('withdrawals.store');
    Route::get('/user/withdrawals/confirm/{token}', [UserWithdrawalController::class, 'confirm'])->name('withdrawals.confirm');
    Route::post('/user/withdrawals/confirm', [UserWithdrawalController::class, 'processConfirmation'])->name('withdrawals.confirm.process');


    // Accounts-Sections Routes
    Route::get('/account', [UserAccountController::class, 'index'])->name('account.index');

    Route::put('/account/profile', [UserProfileController::class, 'update'])->name('profile.update');

    Route::put('/account/security/password', [UserSecurityController::class, 'changePassword'])->name('security.change-password');
    Route::post('/account/security/enable-2fa', [UserSecurityController::class, 'enable2FA'])->name('security.enable-2fa');
    Route::delete('/account/security/disable-2fa', [UserSecurityController::class, 'disable2FA'])->name('security.disable-2fa');


    Route::post('/account/kyc/submit', [UserKycController::class, 'submit'])->name('kyc.submit');
    Route::put('/account/preferences', [UserPreferencesController::class, 'update'])->name('preferences.update');

    Route::get('/account/notifications', [UserAccountController::class, 'notifications'])->name('account.notifications');

    Route::get('/account/activity-log', [UserAccountController::class, 'activityLog'])->name('user.account.activity-log');

    Route::delete('/account/delete', [UserAccountController::class, 'destroy'])->name('account.destroy');


});




// ------------------------
// Deposits
// ------------------------
Route::middleware(['auth', 'role:user'])->prefix('deposit')->name('user.deposit.')->group(function () {
    Route::get('/create', [DepositController::class, 'showForm'])->name('create');
    Route::post('/create', [DepositController::class, 'create'])->name('store');
    Route::get('/success/{deposit}', fn() => view('user.deposits.success'))->name('success');
    Route::get('/cancel/{deposit}', fn() => view('user.deposits.cancel'))->name('cancel');
    Route::get('/history', [DepositController::class, 'history'])->name('history');
});

// ------------------------
// Trader Subscription (Authenticated)
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/trade/search', [UserTraderSubscriptionController::class, 'searchForm'])->name('user.trade.search');
    Route::get('/trade/{trader}/subscribe', [UserTraderSubscriptionController::class, 'showSubscribeForm'])->name('user.trade.showSubscribeForm');
    Route::post('/subscribe/{trader}', [UserTraderSubscriptionController::class, 'subscribe'])->name('user.subscribe');
    Route::post('/unsubscribe/{subscriptionId}', [UserTraderSubscriptionController::class, 'unsubscribe'])->name('user.unsubscribe');
    Route::post('/update-allocation/{subscriptionId}', [UserTraderSubscriptionController::class, 'updateAllocation'])->name('user.updateAllocation');
    Route::post('/transfer-funds', [UserTraderSubscriptionController::class, 'transferFunds'])->name('user.transferFunds');
    Route::get('/my-traders', [UserTraderSubscriptionController::class, 'myTraders'])->name('user.myTraders');
    Route::get('/subscribe/{trader}/allocate', [UserTraderSubscriptionController::class, 'showAllocationForm'])->name('user.subscribe.allocate');
});

// ------------------------
// Trader Comparison (Authenticated)
// ------------------------
Route::middleware('auth')->prefix('traders')->name('traders.')->group(function () {
    Route::post('/add-to-compare/{traderId}', [TraderCompareController::class, 'addToCompare'])->name('addToCompare');
    Route::post('/remove-from-compare/{traderId}', [TraderCompareController::class, 'removeFromCompare'])->name('removeFromCompare');
    Route::get('/compare', [TraderCompareController::class, 'showCompare'])->name('compare');
});

// ------------------------
// Miscellaneous
// ------------------------

// Plisio Webhook
Route::post('/plisio/callback', [PlisioCallbackController::class, 'handle'])->name('plisio.callback');

// Deposit Callback
Route::post('/deposit-callback', [DepositController::class, 'callback'])->name('deposit.callback');

// Authenticated fallback
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect()->route('user.dashboard');
})->name('dashboard');

// Laravel auth fallback
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//FCS API ROUTE

Route::get('/api/calendar', function () {
    $res = Http::get('https://fcsapi.com/api-v3/forex/economy_cal?access_key=' . config('services.fcsapi.key'));
    $json = $res->json();

    return isset($json['response']) ? response()->json($json['response']) : response()->json($json);
});
