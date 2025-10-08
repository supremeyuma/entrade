<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalSetting extends Model
{
    protected $fillable = [
        'cryptocurrency',
        'networks',
        'min_amount',
        'max_amount',
        'fixed_fee',
        'percent_fee',
    ];
    protected $casts = [
        'networks' => 'array', // Cast networks to an array
    ];
}
