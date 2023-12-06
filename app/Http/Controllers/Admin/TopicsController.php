<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\TopicInterface;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicsController extends Controller
{

    public function __construct(
            private TopicInterface $topicRepo,
        )
    {
        $this->middleware([Authenticate::class, VerifyAdmin::class]);
    }

    public function index()
    {
        return Inertia::render('Admin/Topics', [
            'topics' => TopicResource::collection(
                $this->topicRepo->getPaginatedCollection(),
            )
        ]);
    }

    public function store(TopicStoreRequest $request)
    {
        $this->topicRepo->store([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return back();
    }

    public function destroy(Request $request, Topic $topic)
    {
        // authorize if admin or moderator
        // if not forbidden
        if($request->user()->isAdmin() || $request->user()->isModerator()) {
            $this->topicRepo->delete($topic);
            return back();
        }

        abort(403);
    }
}
