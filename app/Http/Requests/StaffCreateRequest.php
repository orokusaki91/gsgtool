<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffCreateRequest extends FormRequest
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
            'username' => 'required|min:4|max:30',
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
            're_password' => 'required_with:password|same:password',
            'profile_picture' => 'image',
            'firstname' => 'required|min:2|max:30',
            'lastname' => 'required|min:2|max:30',
            'nickname' => 'nullable|min:4|max:20',
            'general' => 'nullable|date',
            'birthdate' => 'nullable|date',
            'address_1' => 'required|min:5|max:50',
            'address_2' => 'nullable|min:5|max:50',
            'country' => 'required',
            'canton' => 'required|numeric',
            'marital_status' => 'required|numeric',
            'wedding_date' => 'required_if:marital_status, 1|date',
            'nationality' => 'required',
            'work_permit_date' => 'date',
            'acc_type' => 'required|numeric',
            'number_bank' => 'required_if:acc_type, 1',
            'number_post' => 'required_if:acc_type, 2',
            'current_job' => 'required|numeric',
            'auto' => 'required|numeric',
            'driving_license' => 'required|numeric',
            'trousers_size' => 'required|numeric',
            't_shirt_size' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'wedding_date.required_if' => 'The '. __('validation.attributes.wedding_date'). ' field is required when '. __('validation.attributes.marital_status '). ' is '. __('labels.marital_status.1'). '.',
            'number_bank.required_if' => 'The '. __('validation.attributes.number_bank'). ' field is required when '. __('validation.attributes.acc_type '). ' is '. __('labels.acc_type.1'). '.',
            'number_post.required_if' => 'The '. __('validation.attributes.number_post'). ' field is required when '. __('validation.attributes.acc_type '). ' is '. __('labels.acc_type.2'). '.'
        ];
    }
}
