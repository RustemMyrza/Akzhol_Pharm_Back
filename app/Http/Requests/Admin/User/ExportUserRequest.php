<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ExportUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => 'nullable|in:' . User::adminRolesKeys(),
        ];
    }
}
