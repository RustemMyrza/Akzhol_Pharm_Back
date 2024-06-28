<?php

namespace App\Http\Requests\Admin\Brand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'logo' => 'nullable|image|max:3072'
        ];
    }
}
