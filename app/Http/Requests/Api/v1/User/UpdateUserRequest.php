<?php

namespace App\Http\Requests\Api\v1\User;

use App\Http\Requests\Api\ApiFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends ApiFormRequest
{
    protected $errorMessage = 'failed to update user';
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
        $user = $this->getUserModelByRequestUserId();

        return [
            ...$this->userRules($user->id),
            ...$this->profileRules($user->profile->id)
        ];
    }

    private function userRules($userId)
    {
        return [
            'user.email' => ['required', Rule::unique('users', 'email')->ignore($userId), 'email', 'max:320'],
        ];
    }

    private function profileRules($profileId)
    {
        return [
            'profile.nickname' => ['required', Rule::unique('profiles', 'nickname')->ignore($profileId), 'string', 'max:20'],
            'profile.first_name' => ['required', 'string', 'max:100'],
            'profile.last_name' => ['required', 'string', 'max: 100'],
        ];
    }

    private function getUserModelByRequestUserId()
    {
        $userId = $this->user_id;

        return User::findOrFail($userId);
    }
}
