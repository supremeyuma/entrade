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
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
