<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\FeatureItem
 *
 * @property int $id
 * @property int|null $title
 * @property int $feature_id
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Feature|null $feature
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeatureItem withTranslations()
 * @mixin \Eloquent
 */
class FeatureItem extends Model
{
    const CACHE_TIME = 60 * 60 * 24;

    protected $fillable = [
        'title',
        'position',
        'is_active',
        'feature_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function feature()
    {
        return $this->hasOne(Feature::class, 'id', 'feature_id');
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate'])->orderBy('position')->orderBy('id');
    }
}
