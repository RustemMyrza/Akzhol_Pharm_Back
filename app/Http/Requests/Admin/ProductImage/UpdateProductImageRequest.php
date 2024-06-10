<?php

namespace App\Http\Requests\Admin\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:4096',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
