<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccountSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'two_factor_enabled',
        'language',
        'timezone',
        'email_notifications',
        'notify_on_trade_activity',
        'notify_on_withdrawal',
        'notify_on_referral',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
