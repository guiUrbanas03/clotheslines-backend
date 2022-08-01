<?php

namespace App\Http\Requests\Api\v1\Playlist;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaylistRequest extends FormRequest
{
    protected $errorMessage = 'Failed to update playlist';

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
            'playlist' => 'required',
            'playlist.profile_id' => ['required'],
            'playlist.title' => ['required', 'string', 'min:1', 'max:50'],
            'playlist.description' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
