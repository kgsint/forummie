<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
                        ->take(1),
                    'desc');
    }

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

    public function latestPost()
    {
        return $this->hasOne(Post::class)
                                        ->latestOfMany();
    }
}
