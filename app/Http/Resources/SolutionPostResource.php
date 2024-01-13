<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionPostResource extends JsonResource
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
            'created_at' => DateTimeResource::make($this->created_at),
            'can' => [
                'update' => auth()->user()?->can('update', $this->resource) ?? false,
                'delete' => auth()->user()?->can('delete', $this->resource) ?? false,
            ]
        ];
    }
}
