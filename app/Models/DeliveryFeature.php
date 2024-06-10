<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\DeliveryFeature
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $image
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $image_url
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryFeature withTranslations()
 * @mixin \Eloquent
 */
class DeliveryFeature extends Model
{
    protected $guarded = false;

    protected $appends = ['image_url'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const CACHE_TIME = 60 * 60 * 24;
    const IMAGE_PATH = 'images/delivery-features';

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function getImageUrlAttribute(): string|null
    {
        return $this->image ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->image) : '';
    }

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate'])->orderBy('position')->orderBy('id');
    }
}
