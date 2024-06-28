<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property int|null $title
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Brand isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTranslations()
 * @mixin \Eloquent
 */
class Brand extends Model
{
    protected $appends = ['image_url'];
    
    protected $fillable = [
        'logo',
        'title',
        'is_active',
        'position',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const IMAGE_PATH = 'images/brands-logos';

    const CACHE_TIME = 60 * 60 * 24;

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function getImageUrlAttribute(): string|null
    {
        return $this->logo ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->logo) : null;
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate']);
    }
}
