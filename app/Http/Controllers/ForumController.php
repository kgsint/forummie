<?php

namespace App\Http\Controllers;

use App\Http\QueryFilters\NoRepliesQueryFilter;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ThreadResource;
use Spatie\QueryBuilder\AllowedFilter;

class ForumController extends Controller
{
    public function index()
    {
        return Inertia::render('Forum/Index', [
            'threads' => ThreadResource::collection(
                QueryBuilder::for(Thread::class)
                            ->with(['topic', 'user', 'latestPost.user', 'posts'])
                            ->allowedFilters($this->customAllowedFilters())
                            ->orderByLatestPost()
                            ->orderBy('created_at', 'desc')
                            ->paginate(10)
            ),
        ]);
    }

    public function show(Thread $thread)
    {
        // eager load
        $thread->load(['user', 'posts']);

        return Inertia::render('Forum/Show', [
            'thread' => new ThreadResource($thread),
            'posts' => PostResource::collection(
                                    Post::whereBelongsTo($thread)
                                                                ->with(['user', 'thread', 'replies'])
                                                                ->whereNull('parent_id')
                                                                ->oldest()
                                                                ->paginate(10)
                                ),
        ]);
    }

    // custom filters for spaite/QueryBuilder
    private function customAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter)
        ];
    }
}
