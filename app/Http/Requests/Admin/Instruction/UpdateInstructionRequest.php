<?php

namespace App\Http\Requests\Admin\Instruction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstructionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|array',
            'title.*' => 'nullable',

            'file' => 'nullable|array',
            'file.*' => 'nullable|max:10240',

            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'image' => 'nullable|image|max:4096',
        ];
    }
}
