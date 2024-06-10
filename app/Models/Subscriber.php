<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscriber
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $email
 * @property string|null $email_verified_at
 * @property string|null $token
 * @property int $is_news
 * @property int $is_sales
 * @property int $is_promotions
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsPromotions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereIsSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUserId($value)
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
