<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSeoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'meta_title' => 'required|array',
            'meta_title.*' => 'nullable',
            'meta_description' => 'required|array',
            'meta_description.*' => 'nullable',
            'meta_keyword' => 'required|array',
            'meta_keyword.*' => 'nullable',
        ];
    }
}
