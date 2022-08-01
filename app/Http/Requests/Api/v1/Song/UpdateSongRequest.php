<?php

namespace App\Http\Requests\Api\v1\Song;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSongRequest extends FormRequest
{
    protected $errorMessage = 'Failed to update song';

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
            'song' => 'required',
            'song.playlist_id' => ['required'],
            'song.name' => ['required', 'string', 'min:1', 'max:255'],
            'song.artist' => ['required', 'string', 'min:1', 'max:255'],
            'song.album' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
