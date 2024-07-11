<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProductRequest extends FormRequest
{
    public function rules(Request $request): array
    {
        $product = $request->route('product');
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'nullable|array',
            'description.*' => 'nullable',
            'instruction' => 'nullable|array',
            'instruction.*' => 'nullable',

            'vendor_code' => "required|unique:products,vendor_code,{$product->id}",
            'status' => 'required|in:0,1',

            'price' => 'required|integer',
            'discount' => 'nullable|integer|min:0|max:100',
//            'bulk_price' => 'nullable|integer',
//            'stock_quantity' => 'nullable|integer',

            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'product_filter_items' => 'nullable',
            'product_feature_items' => 'nullable',

            'is_active' => 'nullable|in:0,1',

            'position' => 'required|integer',
            'image' => 'nullable|image|max:4096',
            'youtube_link' => 'nullable',

//            'specification_table' => 'nullable|array',
//            'size_image' => 'nullable|image|max:10240',
//            'installation_image' => 'nullable|image|max:10240',
//            'collapsible_diagram' => 'nullable',

//            'feature_image' => 'nullable|image|max:10240',
            'document' => 'nullable|file|max:20480|mimetypes:' . Product::getMimeTypesAsString(),
        ];
    }
}
