<?php

namespace App\Http\Requests\Admin\Instruction;

use Illuminate\Foundation\Http\FormRequest;

class DeleteInstructionFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'language' => ['required']
        ];
    }
}
