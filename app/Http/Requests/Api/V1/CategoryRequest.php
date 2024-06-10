<?php

namespace App\Http\Requests\Api\V1;

class CategoryRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'sub_category_id' => 'nullable|integer|exists:sub_categories,id',

            'filter_item_ids' => 'nullable|string',
            'feature_item_ids' => 'nullable|string',

            'feature_item_ranges' => 'nullable|array',
            'feature_item_ranges.*.id' => 'required|integer',
            'feature_item_ranges.*.min' => 'required|integer',
            'feature_item_ranges.*.max' => 'required|integer',
        ];
    }
}
