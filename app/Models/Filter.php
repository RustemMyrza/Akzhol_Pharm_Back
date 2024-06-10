<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Filter
 *
 * @property int $id
 * @property int|null $title
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterItem> $filterItems
 * @property-read int|null $filter_items_count
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Filter isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter withTranslations()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $filterCategories
 * @property-read int|null $filter_categories_count
 * @mixin \Eloquent
 */
class Filter extends Model
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

    public function filterItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FilterItem::class, 'filter_id', 'id');
    }

    public function filterCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_filters',
            'filter_id',
            'category_id'
        );
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate'])->orderBy('position')->orderBy('id');
    }
}
