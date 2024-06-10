<?php

namespace App\Http\Requests\Admin\NotificationMessage;

use App\Enum\NotificationMessageTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'type' => 'required|in:' . NotificationMessageTypeEnum::getTypesKeysString(),
        ];
    }
}
