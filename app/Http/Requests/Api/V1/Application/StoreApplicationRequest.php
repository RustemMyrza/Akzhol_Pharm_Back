<?php

namespace App\Http\Requests\Api\V1\Application;

use App\Http\Requests\Api\V1\BaseApiRequest;

class StoreApplicationRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'nullable|max:150',
            'name' => 'required|max:150',
            'email' => 'nullable|email|max:150',
            'message' => 'nullable|string|max:5000',
        ];
    }
}
