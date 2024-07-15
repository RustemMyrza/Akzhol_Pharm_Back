<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_amount',
        'description'
    ];

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }
}
