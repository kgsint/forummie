<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Spatie\LaravelMarkdown\MarkdownRenderer;
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
            'body_markdown' => $this->body, // raw markdown in database
            'body' =>  app(MarkdownRenderer::class)->highlightTheme('material-theme-palenight')->toHtml($this->body), // markdown to html
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'no_of_posts' => $this->posts?->count() ?? 0,
            'solution' => PostResource::make($this->whenLoaded('solution')),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => DateTimeResource::make($this->created_at),
            'can' => [
                'manage' => auth()->user()?->can('manage', $this->resource) ?? false,
                'update' => auth()->user()?->can('update', $this->resource) ?? false,
                'delete' => auth()->user()?->can('delete', $this->resource) ?? false,
            ]
        ];
    }
}
