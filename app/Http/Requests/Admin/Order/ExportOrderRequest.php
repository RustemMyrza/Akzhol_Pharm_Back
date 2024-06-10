<?php

namespace App\Http\Requests\Admin\Order;

use App\Enum\OrderStatusEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class ExportOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_type' => 'required|in:' . UserTypeEnum::getTypeKeysString(),
            'status' => 'nullable|in:' . OrderStatusEnum::getStatusKeysString(),
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ];
    }
}
