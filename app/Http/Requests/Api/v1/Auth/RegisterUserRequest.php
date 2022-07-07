<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends ApiFormRequest
{
    protected $errorMessage = 'Failed to register user';

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
            ...$this->userRules(),
            ...$this->profileRules(),
        ];
    }

    private function userRules()
    {
        return [
            'user' => 'required',
            'user.email' => ['required', Rule::unique('users', 'email'), 'email', 'max:320'],
            'user.password' => ['required', 'string', 'max:999', 'min:8', 'confirmed'],
            'user.password_confirmation' => ['required', 'string', 'max:999', 'min:8'],
        ];
    }

    private function profileRules()
    {
        return [
            'profile' => 'required',
            'profile.nickname' => ['required', Rule::unique('profiles', 'nickname'), 'string', 'max:20'],
            'profile.first_name' => ['required', 'string', 'max:100'],
            'profile.last_name' => ['required', 'string', 'max: 100'],
            'profile.country' => ['required', 'string', 'max:320']
        ];
    }
}
