<?php

namespace App\Http\Requests\Admin\SeoPage;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeoPageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'page' => 'required|string|max:100|unique:seo_pages,page',

            'meta_title' => 'nullable|array',
            'meta_title.*' => 'nullable',

            'meta_description' => 'nullable|array',
            'meta_description.*' => 'nullable',

            'meta_keyword' => 'nullable|array',
            'meta_keyword.*' => 'nullable',

            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
