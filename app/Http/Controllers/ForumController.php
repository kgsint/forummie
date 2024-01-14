<?php

namespace App\Http\Controllers;

use App\Contracts\PostInterface;
use App\Contracts\ThreadInterface;
use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
use Inertia\Inertia;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\ThreadResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class ForumController extends Controller
{
    public function __construct(
        private ThreadInterface $threadRepo,
        private PostInterface $postRepo,
    )
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy']);
    }

    // all
    public function index()
    {
        return Inertia::render('Forum/Index', [
            'threads' => ThreadResource::collection(
                $this->threadRepo->getFilterablePaginatedCollection()
            ),
        ]);
    }

    // show
    public function show(Thread $thread)
    {
        // jump to post position
        if($postId = request('post')) {
            return redirect()->route(
                'forum.show', [
                    'thread' => $thread,
                    'page' => $this->calculatePageForPost($thread, $postId),
                    'post_id' => $postId]
                );
        }

        // eager load
        $thread->load(['topic', 'posts', 'user', 'solution']);

        return Inertia::render('Forum/Show', [
            'thread' => ThreadResource::make($thread),
            'posts' => PostResource::collection(
                $this->postRepo->getByThread($thread),
            ),
        ]);
    }

    // store
    public function store(ThreadStoreRequest $request)
    {
        // store into db
        $thread = $this->threadRepo->store($request->only('title', 'body', 'topic_id'));

        // redirect
        return redirect()->route('forum.show', $thread->slug);
    }

    // update
    public function update(ThreadUpdateRequest $request, Thread $thread)
    {
        // update
        $this->threadRepo->update($thread, [
            'title' => $request->title,
            'body' => $request->body,
            'topic_id' => $request->topic_id,
        ]);

        // redirect
        return redirect()->route('forum.show', $thread);
    }

    public function destroy(Thread $thread)
    {
        // authorize
        $this->authorize('delete', $thread);

        $this->threadRepo->delete($thread);

        return redirect()->route('forum.index');
    }

    // calculate page no for jumping to the location of currenlty created post/rely
    private function calculatePageForPost(Thread $thread, $postId)
    {
        // exclude nested replies
        $posts = $thread->posts()->where(fn($query) => $query->where('parent_id', null))->get();

        // search for index of the post belongs to the thread
        $index = $posts->search(fn($post) => $post->id === (int) $postId);

        // calculate page according to post per page and position of the post in the collection
        $page = (int) ceil(($index + 1) / Post::PAGINATION_COUNT);
        return $page;
    }
}
