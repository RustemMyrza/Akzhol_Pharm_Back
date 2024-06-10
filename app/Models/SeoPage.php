<?php

namespace App\Models;

use App\Traits\HasMetaTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\SeoPage
 *
 * @property int $id
 * @property int $title
 * @property string $page
 * @property int|null $meta_title
 * @property int|null $meta_description
 * @property int|null $meta_keyword
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $updated_at_format
 * @property-read \App\Models\Translate|null $metaDescriptionTranslate
 * @property-read \App\Models\Translate|null $metaKeywordTranslate
 * @property-read \App\Models\Translate|null $metaTitleTranslate
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage withMetaTranslations()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoPage withTranslations()
 * @mixin \Eloquent
 */
class SeoPage extends Model
{
    use HasMetaTranslate;

    protected $fillable = [
        'title',
        'page',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'is_active',
        'position'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['updated_at_format'];

    const CACHE_TIME = 60 * 60 * 24;

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getUpdatedAtFormatAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->format('H:i / d.m.Y') : 'Время не неизвестен';
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
