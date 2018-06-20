<?php

namespace App\Http\Requests;

use App\WarehouseTransaction;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseReturnsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'warehouse_product' => 'required|not_in:0',
            'staff' => 'required|not_in:0',
            'warehouse_depreciation' => 'required',
            'warehouse_qty' => 'required',
        ];
        $whSizeRule = ['warehouse_size' => 'required|not_in:0'];
        $sizes = WarehouseTransaction::getSizesByProduct(request());
        
        $rules = count($sizes) > 0 ? array_merge($rules, $whSizeRule) : $rules;

        return $rules;
    }
}
