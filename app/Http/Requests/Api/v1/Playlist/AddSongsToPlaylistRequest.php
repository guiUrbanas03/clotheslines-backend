<?php

namespace App\Http\Requests\Api\v1\Playlist;

use Illuminate\Foundation\Http\FormRequest;

class AddSongsToPlaylistRequest extends FormRequest
{
    protected $errorMessage = 'Failed to add songs to playlist';
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
            'songs' => 'required|array',
            'songs.*.name' => ['required', 'string', 'min:1', 'max:255'],
            'songs.*.artist' => ['required', 'string', 'min:1', 'max:255'],
            'songs.*.album' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
