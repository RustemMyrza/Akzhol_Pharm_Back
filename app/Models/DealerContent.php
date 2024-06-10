<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\DealerContent
 *
 * @property int $id
 * @property int|null $description
 * @property string|null $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealerContent withTranslations()
 * @mixin \Eloquent
 */
class DealerContent extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    const CACHE_TIME = 60 * 60 * 24;

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['descriptionTranslate']);
    }
}
