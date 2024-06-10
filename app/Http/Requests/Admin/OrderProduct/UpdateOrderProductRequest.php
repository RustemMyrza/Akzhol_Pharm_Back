<?php

namespace App\Http\Requests\Admin\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'discount' => 'required|integer',
            'total_price' => 'required|integer',
        ];
    }
}
