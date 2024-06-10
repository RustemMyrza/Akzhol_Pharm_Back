<?php

namespace App\Http\Requests\Admin\FeatureItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
