<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:3|max:150',
            'last_name' => 'required|string|min:3|max:150',
            'email' => 'required|email|min:3|max:150|unique:users,email',
            'phone' => 'nullable|min:3|max:150|unique:users,phone',
            'password' => 'required|min:4|max:255',
            'role' => 'required|in:' . User::adminRolesKeys(),
            'photo' => 'nullable|image|max:3072',
        ];
    }
}
