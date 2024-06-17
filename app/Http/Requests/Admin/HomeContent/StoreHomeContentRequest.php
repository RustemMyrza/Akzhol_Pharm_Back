<?php

namespace App\Http\Requests\Admin\HomeContent;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeContentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => '|array',
            'title.*' => '',
            'description' => '|array',
            'description.*' => '',
        ];
    }
}
