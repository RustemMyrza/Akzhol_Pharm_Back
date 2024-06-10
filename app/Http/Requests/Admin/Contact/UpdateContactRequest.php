<?php

namespace App\Http\Requests\Admin\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{

    public function rules()
    {
        return [
            'address' => 'required|array',
            'address.*' => 'required',
            'work_time' => 'required|array',
            'work_time.*' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:255',
            'phone_2' => 'nullable|max:255',
            'map_link' => 'nullable|max:5000',
        ];
    }
}
