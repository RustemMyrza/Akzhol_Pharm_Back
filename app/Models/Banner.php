<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Banner
 *
 * @property int $id
 * @property int|null $image
 * @property int|null $mobile_image
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $imageTranslate
 * @property-read \App\Models\Translate|null $mobileImageTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Banner isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereMobileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner withTranslations()
 * @mixin \Eloquent
 */
class Banner extends Model
{
    const CACHE_TIME = 60 * 60 * 24;
    const IMAGE_PATH = 'images/banners';

    protected $fillable = [
        'image',
        'mobile_image',
        'is_active',
        'position'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function imageTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'image');
    }

    public function mobileImageTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'mobile_image');
    }

    public function imageUrl($files, string $language = 'ru'): string
    {
        $filteredImages = array_filter($files->only(Translate::LANGUAGES));
        if (!$filteredImages) return false;
        $image = $filteredImages[$language] ?? $filteredImages[array_key_first($filteredImages)];
        return Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $image);
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['imageTranslate', 'mobileImageTranslate'])->orderBy('position')->orderBy('id');
    }
}
