<?php

namespace App\Http\Resources\Song;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'playlist_id' => $this->playlist_id,
            'name' => $this->name,
            'artist' => $this->artist,
            'album' => $this->album,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
