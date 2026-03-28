<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'cryptocurrency',
        'amount',
        'usd_amount',
        'exchange_rate',
        'fee',
        'wallet_address',
        'network',
        'status',
        'confirmation_token',
        'admin_note',
        'confirmed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNetAmountAttribute()
    {
        return $this->amount - $this->fee;
    }
}
