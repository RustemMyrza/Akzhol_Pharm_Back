<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\HomeContent
 *
 * @property int $id
 * @property int|null $title
 * @property int|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeContent withTranslations()
 * @mixin \Eloquent
 */
class HomeContent extends Model
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
