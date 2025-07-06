<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KycVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'rejection_reason',
        'id_document',
        'proof_of_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
