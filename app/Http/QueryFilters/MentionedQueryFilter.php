<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MentionedQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        if(! auth()->user()) {
            return;
        }

        // threads or posts being mentioned
        $query->whereHas(
            'mentions', fn($query) =>
                            $query->where('user_id', auth()->id())
        )->orWhereHas('posts', fn($query) =>
                            $query->whereHas('mentions', fn($query)=> $query->where('user_id', auth()->id())
                            )
        );
    }
}
