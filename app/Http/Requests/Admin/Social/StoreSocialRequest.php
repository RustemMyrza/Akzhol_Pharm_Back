<?php

namespace App\Http\Requests\Admin\Social;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|image|max:2048',
            'link' => 'required|max:255',
            'is_active' => 'nullable|in:0,1',
        ];
    }
}
