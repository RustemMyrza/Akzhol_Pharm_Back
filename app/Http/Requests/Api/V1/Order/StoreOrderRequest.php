<?php

namespace App\Http\Requests\Api\V1\Order;

use App\Enum\DeliveryTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\UserTypeEnum;
use App\Http\Requests\Api\V1\BaseApiRequest;

class StoreOrderRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'user_type' => 'required|in:' . UserTypeEnum::getTypeKeysString(),
            'delivery_type' => 'required|in:' . DeliveryTypeEnum::getTypeKeysString(),

            'first_name' => 'nullable|max:150',
            'last_name' => 'nullable|max:150',
            'email' => 'nullable|max:150',
            'phone' => 'nullable|max:150',
            'address' => 'nullable|max:255',
            'message' => 'nullable|max:255',

            'organization_name' => 'nullable|max:255',
            'organization_bin' => 'nullable|max:255',
            'organization_email' => 'nullable|max:255',
            'organization_phone' => 'nullable|max:255',
            'organization_legal_address' => 'nullable|max:255',
            'organization_current_address' => 'nullable|max:255',

            'payment_method' => 'nullable|in:' . PaymentMethodEnum::getMethodKeysString(),

            'orderProducts' => 'required|array',
            'orderProducts.*.id' => 'required|exists:products,id',
            'orderProducts.*.quantity' => 'required|integer|max:9999999999',
        ];
    }
}
