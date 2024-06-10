<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\SubCategory
 *
 * @property int $id
 * @property int|null $title
 * @property int $category_id
 * @property string $slug
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory withTranslations()
 * @mixin \Eloquent
 */
class SubCategory extends Model
{
    const CACHE_TIME = 60 * 60 * 24;

    protected $fillable = [
        'title',
        'slug',
        'position',
        'is_active',
        'category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($subCategory) {
            $slug = str()->slug($subCategory->titleTranslate?->ru);
            $count = static::query()->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $subCategory->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

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

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate'])->orderBy('position')->orderBy('id');
    }
}
