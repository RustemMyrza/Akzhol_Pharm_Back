<?php

namespace App\Http\Requests\Admin\AboutUsContent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|array',
            'description.*' => 'required',
            'content' => 'nullable|array',
            'content.*' => 'nullable',
            'image' => 'nullable|image|max:3072',
        ];
    }
}
