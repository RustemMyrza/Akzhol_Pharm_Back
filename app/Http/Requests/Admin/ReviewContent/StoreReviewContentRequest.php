<?php

namespace App\Http\Requests\Admin\ReviewContent;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|array',
            'description.*' => 'nullable',
            'content' => 'nullable|array',
            'content.*' => 'nullable'
        ];
    }
}
