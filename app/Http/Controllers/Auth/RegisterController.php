<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\SiteSetting;
use App\Helpers\SettingsHelper;
use App\Models\Referral;
use App\Helpers\ActivityLogger;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if (SettingsHelper::isReferralEnabled() && request()->filled('referral_code')) {
            $referrer = User::where('referral_code', request()->input('referral_code'))->first();
        
            if ($referrer) {
                // Save referral
                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $newUser->id, // the new user just registered
                ]);

                //Referral Bonus Payout
                $payoutMode = SiteSetting::where('key', 'referral_payout_mode')->value('value');

                switch ($payoutMode) {
                    case 'auto':
                        $referral->update([
                            'status' => 'paid',
                            'bonus_amount' => 10, // example fixed bonus
                        ]);
                
                        $referral->referrer->increment('balance', 10);
                
                        // log activity
                        ActivityLogger::log('referral_bonus_paid', 'Referral bonus automatically paid to user', $referral->referrer_id);
                        break;
                
                    case 'approval':
                        $referral->update([
                            'status' => 'pending',
                            'bonus_amount' => 10, // pre-set amount but pending approval
                        ]);
                
                        ActivityLogger::log('referral_bonus_pending', 'Referral bonus awaiting admin approval', $referral->referrer_id);
                        break;
                
                    case 'manual':
                        // no automatic bonus action
                        ActivityLogger::log('referral_bonus_manual', 'Referral bonus requires manual processing', $referral->referrer_id);
                        break;
                }
                
        
                // Log referral
                if (SettingsHelper::get('log_referrals', 'true') === 'true') {
                    ActivityLogger::log('referral_created', 'Referral created by ' . $referrer->name, $referrer->id);
                }
        
                // Apply bonus if enabled
                if (SettingsHelper::get('referral_bonus_enabled') === 'true') {
                    $bonusAmount = floatval(SettingsHelper::get('referral_bonus_amount'));
                    $bonusType = SettingsHelper::get('referral_bonus_type'); // flat or percentage
                    $bonusTarget = SettingsHelper::get('referral_bonus_credit_to', 'main'); // main or trading
        
                    if ($bonusType === 'percentage') {
                        $bonusAmount = $newUser->initial_deposit * ($bonusAmount / 100);
                    }
        
                    $referrer->increment("{$bonusTarget}_balance", $bonusAmount);
        
                    // Log bonus
                    if (SettingsHelper::get('log_referral_bonus', 'true') === 'true') {
                        ActivityLogger::log('referral_bonus', "Referral bonus of {$bonusAmount} credited to {$bonusTarget} balance for referral.", $referrer->id);
                    }
                }
            }
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
