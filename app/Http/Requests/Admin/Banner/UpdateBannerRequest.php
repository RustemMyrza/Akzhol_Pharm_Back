<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|max:5120',
            'mobile_image' => 'nullable|array',
            'mobile_image.*' => 'nullable|image|max:5120',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
