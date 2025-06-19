<?php

namespace App\Http\Requests\SalesOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_no' => 'nullable|string|max:100',
            'sales_id'     => 'required|exists:sales,id',
            'customer_id'  => 'required|exists:customers,id',
            'items'        => 'required|array|min:1',
            'items.*.product_id'       => 'required|exists:products,id',
            'items.*.quantity'         => 'required|integer|min:1',
            'items.*.production_price' => 'required|numeric|min:0',
            'items.*.selling_price'    => 'required|numeric|min:0',
        ];
    }
}
