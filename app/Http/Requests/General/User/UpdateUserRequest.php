<?php

namespace App\Http\Requests\General\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'id' => 'required|integer|exists:users,id',
            'first_name' => 'string|required|min:2',
            'last_name' => 'string|required|min:2',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'role_id' => 'nullable|string',
            'avatar' => 'nullable',
        ];
    }
}
