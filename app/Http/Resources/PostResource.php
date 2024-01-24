<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public $preserveKeys  = true;

    public function toArray(Request $request): array
    {
        $body = app(MarkdownRenderer::class)->highlightTheme('material-theme-palenight')->toHtml($this->body);
         // search for mentioned user and highlight
         $body = preg_replace('/@(\w+)/', '<a href="/user/$1" class="mentioned-user">@$1</a>', $body);

        return [
            'id' => $this->id,
            'thread' => $this->whenLoaded('thread', fn() => ThreadResource::make($this->thread)),
            'user' => $this->whenLoaded('user', fn() => UserResource::make($this->user)),
            'body' => $body, // markdown to html,
            'body_markdown' => $this->body,
            'created_at' => DateTimeResource::make($this->created_at),
            'parent' => $this->whenLoaded('parent', fn() => PostResource::make($this->parent)),
            'replies' => $this->whenLoaded('replies', fn() => PostResource::collection($this->replies)),
            'is_liked' => $this->whenLoaded('likes', fn() => $this->resource->isAlreadyLikedBy(auth()->user())),
            'like_count' => $this->whenLoaded('likes', fn() => $this->resource->likes->count()),
            'can' => [
                'update' => auth()->user()?->can('update', $this->resource) ?? false,
                'delete' => auth()->user()?->can('delete', $this->resource) ?? false,
            ]
        ];
    }
}
