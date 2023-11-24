<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchMentionableUser extends Controller
{
    public function __invoke(Request $request)
    {
        /**
         * expected => [
         *      ['label' => User's name(@username), 'value' => 'username']
         * ]
         */
        $userList = User::where(
            'username', 'LIKE', "%{$request->username}%")
                        ->get()
                        ->map(
                            fn($user) => ['label' => $user->name, 'value' => $user->username]
                        )
                        ->take(20) // max of 20 items
                        ->toArray();

        return response()->json([
            'items' => $userList
        ]);
    }
}
