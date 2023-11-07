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
            'body' => $this->body,
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'no_of_posts' => $this->posts?->count() ?? 0,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
