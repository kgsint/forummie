<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MarkAsBestAnswer;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\SearchMentionableUser;
use App\Http\Controllers\Admin\TopicsController;
use App\Http\Controllers\Admin\RepliesController;
use App\Http\Controllers\GenerateMarkdownPreview;

// forum routes
Route::controller(ForumController::class)->group(function() {
    Route::get('/', 'index')->name('forum.index');
    Route::get('/threads/{thread:slug}', 'show')->name('forum.show');
    Route::post('/threads', 'store')
                                    ->name('forum.store');
    Route::patch('/threads/{thread}', 'update')
                                                ->name('forum.update');
    Route::delete('/threads/{thread}', 'destroy')
                                                ->name('forum.destroy');
});

// admin routes
Route::prefix('admin')->group(function() {
    // redirect /admin to /admin/users
    Route::redirect('/', '/admin/users');

    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::delete('/user/{user:username}', [UsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/topics', [TopicsController::class, 'index'])->name('admin.topics.index');
    Route::post('/topics', [TopicsController::class, 'store'])->name('admin.topics.store');
    Route::patch('/topic/{topic}', [TopicsController::class, 'update'])->name('admin.topics.update');
    Route::delete('/topics/{topic}', [TopicsController::class, 'destroy'])->name('admin.topics.destroy');

    Route::get('/replies', [RepliesController::class, 'index'])->name('admin.replies.index');
});


Route::middleware('auth')->group(function () {
    // routes for posts or replies for the thread
    Route::post('/{thread}/posts', [PostController::class, 'store'])
                                                        ->name('posts.store');
    Route::patch('/threads/{thread}/posts/{post}', [PostController::class, 'update'])
                                                                        ->name('posts.update');
    Route::delete('/threads/{thread}/posts/{post}', [PostController::class, 'destroy'])
                                                                                    ->name('posts.destroy');
    // markdown preview
    Route::post('/markdown-preview', GenerateMarkdownPreview::class)
                                                                    ->name('markdown.preview');

    Route::patch('/thread/{thread}/{post}/best-answer', MarkAsBestAnswer::class)
                                                                    ->name('threads.best-answer');
    // mentionable list
    Route::post('/mentions/search', SearchMentionableUser::class)
                                                                ->name('mention.search');
    // profile related routes
    Route::get('/account-info', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
