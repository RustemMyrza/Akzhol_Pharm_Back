<?php

namespace App\Traits;

use App\Models\Translate;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasMetaTranslate
{
    public function metaTitleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'meta_title');
    }

    public function metaDescriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'meta_description');
    }

    public function metaKeywordTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'meta_keyword');
    }

    public function scopeWithMetaTranslations($query)
    {
        return $query->with(['metaTitleTranslate', 'metaDescriptionTranslate', 'metaKeywordTranslate']);
    }
}
