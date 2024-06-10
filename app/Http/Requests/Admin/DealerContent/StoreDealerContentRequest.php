<?php

namespace App\Http\Requests\Admin\DealerContent;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealerContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|array',
            'description.*' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:255',
        ];
    }
}
