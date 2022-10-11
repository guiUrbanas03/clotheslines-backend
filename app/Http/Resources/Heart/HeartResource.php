<?php

namespace App\Http\Resources\Heart;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Playlist\PlaylistResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HeartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $hearteable = (object) [
            'type' => $this->parsedHearteable->type,
            'model' => $this->getResourceModel($this->parsedHearteable->type)
        ];

        return [
            'id' => $this->id,
            'profile_id' => $this->profile->id,
            'hearteable' => $hearteable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function getResourceModel($type)
    {
        switch ($type) {
            case 'playlist':
                return new PlaylistResource($this->parsedHearteable->model);
            case 'comment':
                return new CommentResource($this->parsedHearteable->model);
        }
    }
}
