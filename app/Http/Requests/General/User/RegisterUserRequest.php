<?php

namespace App\Http\Requests\General\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'first_name' => 'string|required|min:2',
            'last_name' => 'string|required|min:2',
            'avatar' => 'string|nullable',
            'email' => 'required_without:phone|nullable|email|unique:users,email,null,id,provider_id,NULL',
            'phone' => 'required_without:email|string',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
