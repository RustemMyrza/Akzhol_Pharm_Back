<?php

namespace App\Http\Requests\Admin\SubCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIsActiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_active' => 'required|integer|in:0,1',
            'data_parent_id' => 'required|exists:categories,id',
            'data_id' => 'required|exists:sub_categories,id',
        ];
    }
}
