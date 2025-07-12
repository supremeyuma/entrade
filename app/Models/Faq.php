<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'faq_category_id', 
        'question', 
        'answer',
        'position',
        'is_featured',
    ];

    protected static function booted()
    {
        static::creating(function ($faq) {
            $faq->position = static::max('position') + 1;
        });
    }

    public function category() {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }
}
