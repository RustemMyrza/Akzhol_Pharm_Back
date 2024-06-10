<?php

namespace App\Http\Requests\Admin\Feature;

use App\Enum\FeatureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'type' => 'required|in:' . FeatureTypeEnum::getTypeKeysString(),
        ];
    }
}
