<?php

namespace App\Http\Requests\Admin\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|image|max:4096',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
