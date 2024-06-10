<?php

namespace App\Http\Requests\Admin\Filter;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIsActiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_active' => 'required|integer|in:0,1',
            'data_id' => 'required|exists:filters,id',
        ];
    }
}