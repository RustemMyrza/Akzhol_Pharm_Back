<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'plural_title' => 'required|array',
            'plural_title.*' => 'nullable',

            'is_active' => 'nullable|in:0,1',
            'is_new' => 'nullable|in:0,1',
            'is_important' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'filters' => 'nullable|array',
            'filters.*' => 'nullable',

            'image' => 'nullable|image|max:4096',
        ];
    }
}
