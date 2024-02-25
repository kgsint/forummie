<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Resources\ReplyResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmin::class]);
    }

    public function index()
    {
        return Inertia::render('Admin/Replies', [
            'replies' => ReplyResource::collection(
                Post::with(['user', 'thread', 'spamReports'])
                        ->searchByBody()
                        ->latest()
                        ->paginate(Post::PAGINATION_COUNT)
            ),
        ]);
    }
}
