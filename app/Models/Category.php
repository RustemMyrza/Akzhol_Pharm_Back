<?php

namespace App\Models;

use App\Traits\HasMetaTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $image
 * @property int|null $plural_title
 * @property string $slug
 * @property int $is_new
 * @property int $is_active
 * @property int $is_important
 * @property int $position
 * @property int|null $meta_title
 * @property int|null $meta_description
 * @property int|null $meta_keyword
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Filter> $categoryFilters
 * @property-read int|null $category_filters_count
 * @property-read string $image_url
 * @property-read \App\Models\Translate|null $metaDescriptionTranslate
 * @property-read \App\Models\Translate|null $metaKeywordTranslate
 * @property-read \App\Models\Translate|null $metaTitleTranslate
 * @property-read \App\Models\Translate|null $pluralTitleTranslate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Category isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Category isImportant()
 * @method static \Illuminate\Database\Eloquent\Builder|Category isNew()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notIsNew()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePluralTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withMetaTranslations()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslations()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasMetaTranslate;

    const CACHE_TIME = 60 * 60 * 24;
    const IMAGE_PATH = 'images/categories';
    const DEFAULT_IMAGE_PATH = 'adminlte-assets/dist/img/categories/category-default.png';

    protected $fillable = [
        'title',
        'image',
        'plural_title',
        'slug',
        'position',
        'is_active',
        'is_new',
        'is_important',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['image_url'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $slug = str()->slug($category->titleTranslate?->ru);
            $count = static::query()->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $category->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->image) : asset(self::DEFAULT_IMAGE_PATH);
    }

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function pluralTitleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'plural_title');
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public static function firstCategoryId()
    {
        return static::query()->orderBy('position')->orderBy('id')->first() ?? 1;
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function scopeIsImportant($query)
    {
        return $query->where('is_important', '=', 1);
    }

    public function scopeNotIsNew($query)
    {
        return $query->where('is_new', '=', 0);
    }

    public function scopeIsNew($query)
    {
        return $query->where('is_new', '=', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->with('titleTranslate');
    }

    public function categoryFilters(): BelongsToMany
    {
        return $this->belongsToMany(
            Filter::class,
            'category_filters',
            'category_id',
            'filter_id'
        );
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate', 'pluralTitleTranslate'])->orderBy('position')->orderBy('id');
    }
}
