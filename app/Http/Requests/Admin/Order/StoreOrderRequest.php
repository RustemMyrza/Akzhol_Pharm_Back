<?php

namespace App\Http\Requests\Admin\Order;

use App\Enum\DeliveryTypeEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_type' => 'required|in:' . UserTypeEnum::getTypeKeysString(),
            'delivery_type' => 'required|in:' . DeliveryTypeEnum::getTypeKeysString(),
            'user_id' => 'required|exists:users,id',

            'first_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'message' => 'nullable|max:5000',

            'organization_name' => 'nullable|max:255',
            'organization_bin' => 'nullable|max:255',
            'organization_email' => 'nullable|max:255',
            'organization_phone' => 'nullable|max:255',
            'organization_legal_address' => 'nullable|max:255',
            'organization_current_address' => 'nullable|max:255',

            'payment_method' => 'nullable|in:' . PaymentMethodEnum::getMethodKeysString(),
            'status' => 'nullable|in:' . OrderStatusEnum::getStatusKeysString(),
        ];
    }
}
