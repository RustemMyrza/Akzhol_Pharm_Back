<?php

namespace App\Http\Requests\Admin\HomeContent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',
            'description' => 'required|array',
            'description.*' => 'required',
        ];
    }
}
