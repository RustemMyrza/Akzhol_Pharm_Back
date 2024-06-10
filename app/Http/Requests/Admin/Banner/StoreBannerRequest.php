<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|array',
            'image.*' => 'required|image|max:5120',
            'mobile_image' => 'required|array',
            'mobile_image.*' => 'required|image|max:5120',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
