<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MarkAsBestAnswer;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\SearchMentionableUser;
use App\Http\Controllers\GenerateMarkdownPreview;

// forum routes
Route::controller(ForumController::class)->group(function() {
    Route::get('/', 'index')->name('forum.index');
    Route::get('/threads/{thread:slug}', 'show')->name('forum.show');
    Route::post('/threads', 'store')
                                    ->middleware('auth')
                                    ->name('forum.store');
    Route::patch('/threads/{thread}', 'update')
                                                ->middleware('auth')
                                                ->name('forum.update');
    Route::delete('/threads/{thread}', 'destroy')
                                                ->middleware('auth')
                                                ->name('forum.destroy');
});

Route::prefix('admin')->group(function() {
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users')->middleware('auth');
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
    Route::patch('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
