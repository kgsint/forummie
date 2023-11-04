<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MineQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // do nothing if unauthenticated
        if(! $user = auth()->user()) {
            return;
        }

        // threads belongs to currently authenticated user
        $query->whereBelongsTo($user);
    }
}
