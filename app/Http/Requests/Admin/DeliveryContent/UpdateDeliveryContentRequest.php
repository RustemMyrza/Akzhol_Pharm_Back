<?php

namespace App\Http\Requests\Admin\DeliveryContent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|array',
            'description.*' => 'required',
            'content' => 'required|array',
            'content.*' => 'required',
        ];
    }
}
