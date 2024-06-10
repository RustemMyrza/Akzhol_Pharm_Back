<?php

namespace App\Http\Requests\Admin\OrderProduct;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'discount' => 'required|integer',
            'total_price' => 'required|integer',
        ];
    }
}
