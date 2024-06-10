<?php

namespace App\Http\Requests\Admin\Instruction;


use Illuminate\Foundation\Http\FormRequest;

class StoreInstructionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required',

            'file' => 'required|array',
            'file.*' => 'required|max:10240',

            'is_active' => 'nullable|in:0,1',
            'position' => 'required|integer',
            'image' => 'required|image|max:4096',
        ];
    }
}
