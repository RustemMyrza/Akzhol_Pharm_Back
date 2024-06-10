<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIsNewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_new' => 'required|integer|in:0,1',
            'data_id' => 'required|exists:categories,id',
        ];
    }
}
