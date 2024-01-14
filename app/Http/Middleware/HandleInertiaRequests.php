<?php

namespace App\Http\Middleware;

use App\Http\Resources\TopicResource;
use App\Http\Resources\UserResource;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $notifications = cache()->remember(
            'notifications',
            300,
            fn() => User::with('unreadNotifications')->find($request->user()->id)->notifications
        );

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ?
                                new UserResource($request->user())
                                    : null,
                'notifications' => $request->user() ? $notifications : null,
            ],
            'topics' => TopicResource::collection(Topic::orderBy('name')->get()),
            'queryStrings' => (object) $request->query(), // query string(s) for request
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
