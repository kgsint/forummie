<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MarkNotificationAsRead extends Controller
{
    public function __invoke(Request $request, string|int $id)
    {
        $noti = $request->user()->notifications->where('id', $id)->first();
        // dd($noti, $noti->update(['read_at' => now()]));
        $noti->update(['read_at' => now()]);
        // remove cache
        Cache::forget('notifications');

        return redirect($request->redirectUrl);
    }
}
