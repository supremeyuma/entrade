<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalSetting extends Model
{
    protected $fillable = [
        'cryptocurrency',
        'min_amount',
        'max_amount',
        'fixed_fee',
        'percent_fee',
    ];
}
