<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    // user's profile page
    public function show(User $user)
    {
        $user->load(['threads', 'posts']);

        return Inertia::render('Profile/Show', [
            'user' => UserResource::make($user),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        // upload profile avatar if any
        if($request->hasFile('photo')) {
            $this->uploadProfileAvatar($request);
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // upload profile avatar
    private function uploadProfileAvatar(ProfileUpdateRequest $request)
    {
        if($prevPath = auth()->user()->profile_avatar_path) {
            Storage::delete($prevPath);
        }

        $filename = $request->file('photo')->getClientOriginalName() . uniqid() . time();
        $ext = $request->file('photo')->getClientOriginalExtension();

        //  store in storage
        $path = $request->file('photo')->storePubliclyAs('/public/profile-images', "{$filename}.{$ext}");
        // store path in db
        $request->user()->profile_avatar_path = $path;
    }
}
