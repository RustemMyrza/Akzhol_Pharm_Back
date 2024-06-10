<?php

namespace App\Http\Requests\Admin\Agreement;

use App\Models\Agreement;
use Illuminate\Foundation\Http\FormRequest;

class StoreAgreementRequest extends FormRequest
{
    public function rules(): array
    {
        $types = implode(',', array_keys(Agreement::types()));
        return [
            'file' => 'required|array',
            'file.*' => 'nullable|mimes:doc,docx,pdf|max:5120',
            'type' => 'required|in:' . $types
        ];
    }
}
