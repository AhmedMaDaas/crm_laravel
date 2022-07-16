<?php

namespace App\Http\Requests\General\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
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
            'email' => 'required|email',
            'password' => 'required|string',
            'role_id' => 'required|integer|exists:roles,id',
            'avatar' => 'nullable',
        ];
    }
}
