<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Rules\StringOrImage;

use App\Exceptions\RequestException;

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
            'email' => 'required_without:phone|nullable|email|unique:users,email,null,id',
            'phone' => 'required_without:email|nullable|string|unique:users,phone,null,id',
            'password' => 'required|string',
            'role_id' => 'required|integer|exists:roles,id',
            'avatar' => ['nullable', new StringOrImage],
        ];
    }

    public function failedAuthorization()
    {
        throw new RequestException($message = "Unauthorized", $detailed_error = null , $code = 403);
    }
}
