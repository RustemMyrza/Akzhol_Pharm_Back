<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\AboutUsContent
 *
 * @property int $id
 * @property int|null $description
 * @property int|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translate|null $contentTranslate
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AboutUsContent withTranslations()
 * @mixin \Eloquent
 */

class ReviewsContent extends Model
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

    public function contentTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'content');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['descriptionTranslate', 'contentTranslate']);
    }
}
