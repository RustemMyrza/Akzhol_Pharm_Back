<?php

namespace App\Http\Requests\Admin\Application;

use App\Enum\ApplicationEnum;
use Illuminate\Foundation\Http\FormRequest;
class StoreApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'nullable|max:255',
            'name' => 'required|max:255',
            'email' => 'nullable|max:255',
            'message' => 'nullable|max:5000',
            'status' => 'required|in:' . ApplicationEnum::getStatusKeysString(),
        ];
    }
}
