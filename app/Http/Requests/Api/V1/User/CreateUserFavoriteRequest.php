<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\BaseApiRequest;

class CreateUserFavoriteRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id'
        ];
    }
}
