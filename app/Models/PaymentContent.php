<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property int|null $title
 * @property int|null $description
 * @property string|null $image
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @property-read string|null $image_url
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod withTranslations()
 * @mixin \Eloquent
 */

class PaymentContent extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['image_url'];

    const CACHE_TIME = 60 * 60 * 24;
    const IMAGE_PATH = 'images/payment-content-images';

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function contentTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'content');
    }

    public function getImageUrlAttribute(): string|null
    {
        return $this->image ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->image) : null;
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['descriptionTranslate', 'contentTranslate']);
    }
}
