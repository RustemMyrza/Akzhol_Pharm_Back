<?php

namespace App\Http\Requests\Admin\PaymentContent;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'nullable|array',
            'description.*' => 'nullable',
            'content' => 'nullable|array',
            'content.*' => 'nullable',
            'image' => 'nullable|image|max:3072',
        ];
    }
}
