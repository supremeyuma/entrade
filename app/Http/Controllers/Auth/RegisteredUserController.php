<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate unique referral code
        do {
            $referralCode = strtoupper(Str::random(8));
        } while (User::where('referral_code', $referralCode)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referralCode,
        ]);
        
        //To assign role to new user as "user"
        $user->assignRole('user');

        event(new Registered($user));

        //Creating User Account Settings Table
        /*User::created(function ($user) {
            $user->settings()->create(); // sets defaults
        });

        //Creating User Balances
        User::created(function ($user) {
            $user->balance()->create();
        }
        
        )*/
        

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
