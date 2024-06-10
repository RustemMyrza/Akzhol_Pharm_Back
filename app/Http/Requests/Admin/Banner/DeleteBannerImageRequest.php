<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBannerImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'language' => 'required',
            'banner_type' => 'required'
        ];
    }
}
