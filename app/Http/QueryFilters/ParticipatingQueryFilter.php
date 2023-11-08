<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ParticipatingQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // do nothing if unauthenticated
        if(! $user = auth()->user()) {
            return;
        }

        // post of a thread where the current user has posted or participated
        // where the owner of the thread is not the current user
        $query
            ->where('user_id', '!=', auth()->id())
            ->whereHas('posts', fn($query) => $query->whereBelongsTo($user));
    }
}
