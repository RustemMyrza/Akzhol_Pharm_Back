<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document' => 'required|file|mimes:zip|max:51200'
        ];
    }
}
