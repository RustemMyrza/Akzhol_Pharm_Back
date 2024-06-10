<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document' => 'required|file|mimes:xlsx,xls|max:20480'
        ];
    }
}
