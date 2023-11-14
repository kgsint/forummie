<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Thread;
use App\Contracts\ThreadInterface;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\QueryFilters\MineQueryFilter;
use App\Http\QueryFilters\TopicQueryFilter;
use App\Http\QueryFilters\NoRepliesQueryFilter;
use App\Http\QueryFilters\ParticipatingQueryFilter;

class ThreadRepository implements ThreadInterface
{
    // filterable paginated collection
    public function getFilterablePaginatedCollection()
    {
        return QueryBuilder::for(Thread::class)
                                ->with(['topic', 'user', 'posts.thread.user', 'latestPost.user']) // eager load
                                ->allowedFilters($this->customAllowedFilters()) // custom filters
                                ->orderByLatestPost()
                                ->orderBy('created_at', 'desc')
                                ->paginate(Thread::PAGINATION_COUNT)
                                ->appends(request()->all());
    }

    // find by id
    public function findById(string|int $id)
    {
        return Thread::find($id);
    }

    public function relatedPosts(Thread $thread)
    {
        return Post::whereBelongsTo($thread)
                        ->with(['user', 'thread', 'parent', 'replies.user', 'replies.thread', 'replies.parent',])
                        ->whereNull('parent_id')
                        ->oldest()
                        ->paginate(Post::PAGINATION_COUNT);
    }

    // store into database
    public function store(array $data)
    {
        return auth()->user()
                            ->threads()->create([
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'topic_id' => $data['topic_id'],
                            ]);
    }

    // custom filters for spaite/QueryBuilder
    private function customAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter),
            AllowedFilter::custom('mine', new MineQueryFilter),
            AllowedFilter::custom('participating', new ParticipatingQueryFilter),
            AllowedFilter::custom('topic', new TopicQueryFilter),
        ];
    }
}
