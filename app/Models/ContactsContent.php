<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class ContactsContent extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const CACHE_TIME = 60 * 60 * 24;

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate', 'descriptionTranslate']);
    }
}
