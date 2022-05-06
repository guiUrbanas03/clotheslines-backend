<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Http\Requests\Api\ApiFormRequest;

class LoginRequest extends ApiFormRequest
{
    protected $errorMessage = 'error while logging user';

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
            'email' => ['required', 'email', 'max:320'],
            'password' => ['required', 'string', 'max:999', 'min:8']
        ];
    }
}
