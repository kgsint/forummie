<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\DateTimeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $accountType = match($this->type) {
            User::DEFAULT => 'user',
            User::MODERATOR => 'moderator',
            User::ADMIN => 'admin',
        };

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'threads' => $this->whenLoaded('threads', fn() => ThreadResource::collection($this->threads)),
            'posts' => $this->whenLoaded('posts', fn() => PostResource::collection($this->posts)),
            'username' => $this->username,
            'type' => $accountType,
            'avatar' => $this->getAvatar(),
            'joined_at' => DateTimeResource::make($this->created_at),
            'unread_notifications' => $this->unreadNotifications,
            'can' => [
                'update' => request()->user()?->can('update', $this->resource),
            ]
        ];
    }
}
