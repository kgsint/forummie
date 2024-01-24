<?php

namespace App\Concerns;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLike
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function likedBy(User $user)
    {
        $this->likes()->create(['user_id' => $user->id]);
    }

    public function unlikeBy(User $user)
    {
        ($this->likes()->where('user_id', $user->id)->first())?->delete();
    }

    public function isAlreadyLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
