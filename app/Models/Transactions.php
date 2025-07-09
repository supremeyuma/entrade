<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'type', 'balance_type', 'category', 'amount', 'user_note', 'admin_note', 'meta'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
