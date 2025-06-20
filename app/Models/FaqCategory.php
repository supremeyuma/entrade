<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function faqs() {
        return $this->hasMany(Faq::class);
    }
}
