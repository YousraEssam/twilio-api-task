<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    // {
    //     throw new \Illuminate\Validation\ValidationException(response()->json($validator->errors(), 422));
    // }

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
            'email' => 'required|email|string',
            'phone_number' => 'required|numeric'
        ];
    }
}
