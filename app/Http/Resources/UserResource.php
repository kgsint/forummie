<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'username' => $this->username,
            'type' => $accountType,
            'avatar' => $this->getAvatar(),
            'joined_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
