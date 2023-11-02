<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
