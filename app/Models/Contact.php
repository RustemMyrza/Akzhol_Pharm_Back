<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $phone_2
 * @property int|null $address
 * @property int|null $work_time
 * @property string|null $map_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $addressTranslate
 * @property-read \App\Models\Translate|null $workTimeTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereWorkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withTranslations()
 * @mixin \Eloquent
 */
class Contact extends Model
{
    const CACHE_TIME = 60 * 60 * 24;

    protected $fillable = [
        'address',
        'work_time',
        'phone',
        'phone_2',
        'email',
        'map_link'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function addressTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'address');
    }

    public function workTimeTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'work_time');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['addressTranslate', 'workTimeTranslate']);
    }
}
