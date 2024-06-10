<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryFilter
 *
 * @property int $category_id
 * @property int $filter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryFilter whereUpdatedAt($value)
 * @property-read \App\Models\Filter|null $filter
 * @mixin \Eloquent
 */
class CategoryFilter extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function filter()
    {
        return $this->hasOne(Filter::class, 'id', 'filter_id');
    }
}
