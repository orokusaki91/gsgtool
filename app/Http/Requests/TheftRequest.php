<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheftRequest extends FormRequest
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
        return [
            'client_id' => 'required|numeric',
            'date' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required|date',
            'nationality' => 'required',
            'gender' => 'required|numeric',
            'goods' => 'required',
            'price' => 'required',
            'damaged' => 'required|integer',
            'description' => 'required|min:5'
        ];
    }
}
