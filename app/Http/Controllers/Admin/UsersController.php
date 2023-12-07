<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
            'users' => UserResource::collection(
                $users
            ),
        ]);
    }

    public function store(UserStoreRequest $request)
    {

    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
