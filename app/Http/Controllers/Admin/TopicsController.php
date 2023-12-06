<?php

namespace App\Http\Controllers\Admin;

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

    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmin::class]);
    }

    public function index()
    {
        return Inertia::render('Admin/Topics', [
            'topics' => TopicResource::collection(
                Topic::
                    searchByName()
                    ->latest()
                    ->paginate(Topic::PAGINATION_COUNT),
            )
        ]);
    }

    public function store(TopicStoreRequest $request)
    {
        Topic::create([
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
            $topic->delete();
            return back();
        }

        abort(403);
    }
}
