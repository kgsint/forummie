<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UnsolvedQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        $query->where('solution_post_id', null);
    }
}
