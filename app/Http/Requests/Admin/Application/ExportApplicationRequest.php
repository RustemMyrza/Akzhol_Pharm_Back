<?php

namespace App\Http\Requests\Admin\Application;

use App\Enum\ApplicationEnum;
use Illuminate\Foundation\Http\FormRequest;

class ExportApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'nullable|in:' . ApplicationEnum::getStatusKeysString(),
        ];
    }
}
