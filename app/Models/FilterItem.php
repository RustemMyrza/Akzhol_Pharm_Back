<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\FilterItem
 *
 * @property int $id
 * @property int|null $title
 * @property int $filter_id
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem withTranslations()
 * @property-read \App\Models\Filter|null $filter
 * @mixin \Eloquent
 */
class FilterItem extends Model
{
    const CACHE_TIME = 60 * 60 * 24;

    protected $fillable = [
        'title',
        'position',
        'is_active',
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

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function filter()
    {
        return $this->hasOne(Filter::class, 'id', 'filter_id');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate'])->orderBy('position')->orderBy('id');
    }
}
