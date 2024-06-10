<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class ImportUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document' => 'required|file|mimes:xlsx,xls|max:20480'
        ];
    }
}
