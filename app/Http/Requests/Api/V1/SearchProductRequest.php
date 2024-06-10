<?php

namespace App\Http\Requests\Api\V1;

class SearchProductRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
        ];
    }
}
