<?php

namespace App\Models;

use App\Traits\HasMetaTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $title
 * @property int|null $description
 * @property string $description_lists
 * @property int|null $instruction
 * @property string $installation_image
 * @property string $collapsible_diagram
 * @property string|null $size_image
 * @property string $specification_table
 * @property string $instruction_lists
 * @property int $price
 * @property int $bulk_price
 * @property int $stock_quantity
 * @property int $discount
 * @property string|null $image
 * @property string|null $document
 * @property string|null $feature_image
 * @property string $vendor_code
 * @property int $status
 * @property int $is_new
 * @property int $is_active
 * @property string|null $slug
 * @property int $position
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property int|null $brand_id
 * @property int|null $country_id
 * @property int|null $meta_title
 * @property int|null $meta_description
 * @property int|null $meta_keyword
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Translate|null $descriptionTranslate
 * @property-read string|null $document_url
 * @property-read string|null $feature_image_url
 * @property-read string $image_url
 * @property-read int $old_price_format
 * @property-read int $price_format
 * @property-read string $status_name
 * @property-read \App\Models\Translate|null $instructionTranslate
 * @property-read \App\Models\Translate|null $metaDescriptionTranslate
 * @property-read \App\Models\Translate|null $metaKeywordTranslate
 * @property-read \App\Models\Translate|null $metaTitleTranslate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FeatureItem> $productFeatureItems
 * @property-read int|null $product_feature_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterItem> $productFilterItems
 * @property-read int|null $product_filter_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $productImages
 * @property-read int|null $product_images_count
 * @property-read \App\Models\SubCategory|null $subCategory
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Product isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Product isNew()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBulkPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCollapsibleDiagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescriptionLists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFeatureImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstallationImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInstructionLists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSizeImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecificationTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVendorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withMetaTranslations()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTranslations()
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasMetaTranslate;

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($product) {
            $slug = str()->slug($product->titleTranslate?->ru);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $product->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    protected $fillable = [
        'title',
        'description',
        'instruction',
        'image',
        'feature_image',
        'vendor_code',
        'status',
        'is_new',
        'is_active',
        'slug',
        'position',
        'discount',
        'category_id',
        'sub_category_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'price',
        'bulk_price',
        'stock_quantity',
        'description_lists',
        'installation_image',
        'specification_table',
        'size_image',
        'instruction_lists',
        'collapsible_diagram',
    ];

    protected $casts = [
        'description_lists' => 'array',
        'instruction_lists' => 'array',
        'collapsible_diagram' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'image_url',
        'document_url',
//        'feature_image_url',
        'status_name',
        'price_format',
        'old_price_format'
    ];

    const IMAGE_PATH = 'images/products';
    const DOCUMENT_PATH = 'files/products';
    const DEFAULT_IMAGE_PATH = 'adminlte-assets/dist/img/products/product-default.png';

    const CACHE_TIME = 60 * 60 * 24;

    const DOCUMENT_MIME_TYPES = [
        'application/pdf',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/docx',
    ];

    public static function getMimeTypesAsString(): string
    {
        return implode(',', self::DOCUMENT_MIME_TYPES);
    }

    public static function statuses(): array
    {
        return [
            0 => 'Нет в наличии',
            1 => 'В наличии',
        ];
    }

    public function getStatusNameAttribute(): string
    {
        return self::statuses()[$this->status] ?? 'Стаутс неизвестен';
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

//    public function scopeIsNew($query)
//    {
//        return $query->where('is_new', '=', 1);
//    }

    public function getPriceFormatAttribute(): int
    {
        return $this->discount > 0 ? discountPriceCalculate($this->price, $this->discount) : $this->price;
    }

    public function getOldPriceFormatAttribute(): int
    {
        return $this->price;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->image)
            : asset(self::DEFAULT_IMAGE_PATH);
    }

    public function imagesUrl(string $image): ?string
    {
        return $image
            ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $image)
            : null;
    }

//    public function getFeatureImageUrlAttribute(): string|null
//    {
//        return $this->feature_image
//            ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->feature_image)
//            : null;
//    }

    public function getSizeImageUrlAttribute(): string|null
    {
        return $this->size_image
            ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->size_image)
            : null;
    }

    public function getInstallationImageUrlAttribute(): string|null
    {
        return $this->installation_image
            ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->installation_image)
            : null;
    }

    public function getDocumentUrlAttribute(): string|null
    {
        return $this->document
            ? Storage::disk('custom')->url(self::DOCUMENT_PATH . '/' . $this->document)
            : null;
    }

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function descriptionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function instructionTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'instruction');
    }

    public function specificationTableTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'specification_table');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subCategory(): HasOne
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function productFilterItems(): BelongsToMany
    {
        return $this->belongsToMany(
            FilterItem::class,
            'product_filter_items',
            'product_id',
            'filter_item_id'
        );
    }

    public function productFeatureItems(): BelongsToMany
    {
        return $this->belongsToMany(
            FeatureItem::class,
            'product_feature_items',
            'product_id',
            'feature_item_id'
        );
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate', 'descriptionTranslate', 'instructionTranslate'])->orderBy('position')->orderBy('id');
    }
}
