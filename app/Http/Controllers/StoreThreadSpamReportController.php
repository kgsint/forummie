<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class StoreThreadSpamReportController extends Controller
{
    public function __invoke(Request $request, Thread $thread)
    {
        if($thread->isAlreadyReportedAsSpamBy($request->user())) {
            return response()->json([
                'message' => 'You already reported this thread',
            ], 403);
        }

        $thread->reportAsSpamBy($request->user());

        return response()->json([
            'message' => 'You reported this thread as spam',
        ], 200);
    }
}
