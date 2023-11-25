<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PAGINATION_COUNT = 10;

    public static function booted()
    {
        static::creating(function(Thread $thread) {
            // generating slug
            $thread->slug = Str::slug($thread->title ) . "-" . substr(uniqid(), 0, 8);
        });
    }

    // order by thread's latest post/reply
    public function scopeOrderByLatestPost($query)
    {
        return $query->orderBy(
                Post::select('created_at')
                        ->whereColumn('posts.thread_id', 'threads.id')
                        ->latest()
                        ->take(1)
                        ,'desc');
    }

    // search by thread's title
    public function scopeSearchByTitle($query)
    {
        return $query->when(
            request()->has('s'),
            fn($query) => $query->where('title', 'LIKE', "%" . request('s') . "%")
        );
    }

    // elquoent relationships
    // ---
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function latestPost(): HasOne
    {
        return $this->hasOne(Post::class)
                                        ->latestOfMany();
    }

    public function solution()
    {
        return $this->belongsTo(Post::class, 'solution_post_id');
    }

    // a list of user being mentioned in a thread
    public function mentions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'thread_mention', 'thread_id')
                                                                            ->withTimestamps();
    }
    // --
}
