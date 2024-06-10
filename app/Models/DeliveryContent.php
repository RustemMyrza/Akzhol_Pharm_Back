<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\DeliveryContent
 *
 * @property int $id
 * @property int|null $description
 * @property int|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $contentTranslate
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryContent withTranslations()
 * @mixin \Eloquent
 */
class DeliveryContent extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const CACHE_TIME = 60 * 60 * 24;

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function contentTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'content');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['descriptionTranslate', 'contentTranslate']);
    }
}