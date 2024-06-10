<?php

namespace App\Http\Requests\Admin\DeliveryList;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|array',
            'description.*' => 'required',
            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
        ];
    }
}
