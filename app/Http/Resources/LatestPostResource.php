<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ThreadResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LatestPostResource extends JsonResource
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
            'user' => UserResource::make($this->user),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
