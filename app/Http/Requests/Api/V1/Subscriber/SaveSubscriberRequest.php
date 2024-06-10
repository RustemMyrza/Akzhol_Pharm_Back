<?php

namespace App\Http\Requests\Api\V1\Subscriber;

use App\Http\Requests\Api\V1\BaseApiRequest;

class SaveSubscriberRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:100',
            'is_news' => 'nullable|in:0,1',
            'is_sales' => 'nullable|in:0,1',
            'is_promotions' => 'nullable|in:0,1',
        ];
    }
}
