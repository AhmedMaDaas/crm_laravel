<?php

namespace App\Http\Requests\User;

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
            'email' => 'required_without:phone|nullable|email|unique:users,email,' . $this->id . ',id',
            'phone' => 'required_without:email|nullable|string|unique:users,phone,' . $this->id . ',id',
            'password' => 'nullable|string',
            'role_id' => 'nullable|string',
            'avatar' => 'nullable',
        ];
    }
}
