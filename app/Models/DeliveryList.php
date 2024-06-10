<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\DeliveryList
 *
 * @property int $id
 * @property int|null $description
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryList withTranslations()
 * @mixin \Eloquent
 */
class DeliveryList extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const CACHE_TIME = 60 * 60 * 24;

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['descriptionTranslate'])->orderBy('position')->orderBy('id');
    }
}
