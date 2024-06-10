<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIsNewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_new' => 'required|integer|in:0,1',
            'data_id' => 'required|exists:products,id',
        ];
    }
}
