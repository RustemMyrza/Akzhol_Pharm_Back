<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductFeatureItem
 *
 * @property int $product_id
 * @property int $feature_item_id
 * @property-read \App\Models\FeatureItem|null $featureItem
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeatureItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeatureItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeatureItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeatureItem whereFeatureItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeatureItem whereProductId($value)
 * @mixin \Eloquent
 */
class ProductFeatureItem extends Model
{
    use HasFactory;

    public function featureItem()
    {
        return $this->hasOne(FeatureItem::class, 'id', 'feature_item_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
