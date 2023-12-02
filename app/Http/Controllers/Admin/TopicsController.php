<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Topics', [
            'topics' => TopicResource::collection(
                Topic::latest()->paginate(Topic::PAGINATION_COUNT),
            )
        ]);
    }

    public function store()
    {

    }
}
