<?php

namespace App\Http\Requests\Api\V1;

class ProductRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'slug' => 'required|max:255',
        ];
    }
}
