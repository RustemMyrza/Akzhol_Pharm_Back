<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\BaseApiRequest;
use Illuminate\Http\Request;

class UpdateProfileRequest extends BaseApiRequest
{
    public function rules(Request $request): array
    {
        $user = $request->user();
        return [
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'photo' => 'nullable|image|max:4096',
            'phone' => 'nullable|unique:users,phone,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|max:150',
        ];
    }
}
