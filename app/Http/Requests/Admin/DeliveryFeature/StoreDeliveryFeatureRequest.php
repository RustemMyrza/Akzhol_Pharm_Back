<?php

namespace App\Http\Requests\Admin\DeliveryFeature;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryFeatureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'image' => 'required|image|max:4096',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
