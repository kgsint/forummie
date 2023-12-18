<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserIndexResource;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmin::class]);
    }

    public function index()
    {
        $users = User::
                        when(
                            request('s'),
                            fn($query) => $query->where('name', 'LIKE', "%". request('s') ."%")
                                                ->orWhere('username', 'LIKE', "%". request('s') ."%")
                        )
                        ->latest()
                        ->paginate(User::PAGINATION_COUNT);

        return Inertia::render('Admin/Users', [
            'users' => UserIndexResource::collection($users),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $this->forbiddenIfModeratorCreateAdmin($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'type' => (int) $request->type,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index');
    }

    public function ban(User $user, Request $request)
    {
        $this->authorize('ban', $user);

        $request->validate([
            'banned_reason' => 'required|string|max:255',
        ], [
            'banned_reason.required' => 'Please provide a valid reason',
        ]);

        $user->update([
            'banned_at' => Carbon::now(),
            'banned_reason' => $request->banned_reason,
        ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index');
    }

    private function forbiddenIfModeratorCreateAdmin(UserStoreRequest $request): void
    {
        // moderator cannot create admin
        if(auth()->user()->isModerator() && (int) $request->type === User::ADMIN) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
