<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'address',
        'identification_type',
        'identification_number',
        'passport_number',
        'id_document_path',
        'passport_document_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
