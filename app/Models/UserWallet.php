<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = [
        'user_id', 'cryptocurrency', 'wallet_address', 'network', 'label'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
