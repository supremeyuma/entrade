<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trader;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function traderSubscriptions()
    {
        return $this->hasMany(UserTraderSubscription::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserTraderSubscription::class);
    }

    public function tradeHistories()
    {
        return $this->hasMany(TradeHistory::class);
    }

    public function getReferralLinkAttribute()
    {
        return url('/register?referral_code=' . $this->referral_code);
    }

    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referralCount()
    {
        return $this->referralsMade()->count();
    }

    public function referralBonusTotal()
    {
        return $this->referralsMade()->sum('bonus_amount'); // add this column if bonuses are tracked
    }


    public function copiedTraders()
    {
        return $this->belongsToMany(Trader::class, 'user_trader_subscriptions', 'user_id', 'trader_id')
                    ->withTimestamps()
                    ->withPivot(['amount_allocated', 'status']);
    }

    public function tradeOutcomes()
    {
        return $this->hasManyThrough(
            TradeOutcome::class,    // Final model
            Trader::class,          // Intermediate model
            'id',                   // Foreign key on Trader: Trader.id
            'trader_id',            // Foreign key on TradeOutcome: TradeOutcome.trader_id
            'id',                   // Local key on User: User.id
            'id'                    // Local key on Trader: Trader.id (customize if needed)
        )->whereIn('trader_id', $this->copiedTraders()->pluck('traders.id'));
    }

    public function subscribedTraders()
    {
        return $this->belongsToMany(Trader::class, 'user_trader_subscriptions', 'user_id', 'trader_id');
    }

    public function wallets() {
        return $this->hasMany(UserWallet::class);
    }
    




}
