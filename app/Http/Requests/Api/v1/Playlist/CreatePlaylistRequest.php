<?php

namespace App\Http\Requests\Api\v1\Playlist;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlaylistRequest extends FormRequest
{
    protected $errorMessage = 'Failed to create playlist';

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
            ...$this->playlistRules(),
            ...$this->songsRules()
        ];
    }

    private function playlistRules()
    {
        return [
            'playlist' => ['required', 'array'],
            'playlist.title' => ['required', 'string', 'min:1', 'max:50'],
            'playlist.description' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }

    private function songsRules()
    {
        return [
            'songs' => ['required', 'array', 'min:1', 'max:5'],
            'songs.*.name' => ['required', 'string', 'min:1', 'max:255'],
            'songs.*.artist' => ['required', 'string', 'min:1', 'max:255'],
            'songs.*.album' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
