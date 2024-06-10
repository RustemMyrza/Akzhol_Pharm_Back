<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'nullable',
            'description' => 'required|array',
            'description.*' => 'nullable',
            'image' => 'nullable|image|max:3072',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
