<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'nullable|array',
            'description.*' => 'nullable',
            'instruction' => 'nullable|array',
            'instruction.*' => 'nullable',

            'vendor_code' => 'required|unique:products,vendor_code',
            'status' => 'required|in:0,1',

            'price' => 'required|integer',
            'discount' => 'nullable|integer|min:0|max:100',
//            'bulk_price' => 'nullable|integer',
//            'stock_quantity' => 'nullable|integer',

            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'product_filter_items' => 'nullable',
            'product_feature_items' => 'nullable',
            'is_new' => 'nullable|in:0,1',
            'is_active' => 'nullable|in:0,1',
            'is_promotional' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'image' => 'required|image|max:4096',
            'youtube_link' => 'nullable',
//            'feature_image' => 'nullable|image|max:10240',

//            'specification_table' => 'nullable|array',
//            'size_image' => 'nullable|image|max:10240',
//            'installation_image' => 'nullable|image|max:10240',
//            'collapsible_diagram' => 'nullable',

            'document' => 'nullable|file|max:20480|mimetypes:' . Product::getMimeTypesAsString(),
        ];
    }
}
