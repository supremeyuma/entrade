<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
