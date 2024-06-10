<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->route('user')->id;
        return [
            'first_name' => 'required|string|min:3|max:100',
            'last_name' => 'required|string|min:3|max:100',
            'phone' => "nullable|min:3|max:150|unique:users,phone,{$userId}",
            'password' => 'nullable|min:4|max:255',
            'role' => 'required|in:' . User::adminRolesKeys(),
            'photo' => 'nullable|image|max:3072',
            'email' => "required|email|min:3|max:150|unique:users,email,{$userId}",
        ];
    }
}
