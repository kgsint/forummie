<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class NoRepliesQueryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // thread where has no post (0 post)
        $query->has('posts', '=', 0);
    }
}
