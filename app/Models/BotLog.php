<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'trade_id',
        'market',
        'roi',
        'strategy',
        'summary',
        'inout_date',
        'output_date',
        'errors',
    ];
}
