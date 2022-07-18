<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Rules\StringOrImage;

use App\Exceptions\RequestException;

class UpdateProductRequest extends FormRequest
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
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|integer:exists:users,id',
            'image' => ['required', new StringOrImage],
        ];
    }

    public function failedAuthorization()
    {
        throw new RequestException($message = "Unauthorized", $detailed_error = null , $code = 403);
    }
}
