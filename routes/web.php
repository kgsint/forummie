<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MarkAsBestAnswer;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RepliesController;
use App\Http\Controllers\Admin\TopicsController;
use App\Http\Controllers\SearchMentionableUser;
use App\Http\Controllers\MarkNotificationAsRead;
use App\Http\Controllers\GenerateMarkdownPreview;
use App\Http\Controllers\LikeUnLikeController;
use App\Http\Controllers\StorePostSpamReportController;
use App\Http\Controllers\StoreThreadSpamReportController;

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
    Route::patch('/users/{user}/ban', [UsersController::class, 'ban'])->name('admin.users.ban');
    Route::patch('/users/{user}/unban', [UsersController::class, 'unban'])->name('admin.users.unban');
    Route::delete('/users/{user:username}', [UsersController::class, 'destroy'])->name('admin.users.destroy');

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
    // database notifications
    Route::patch('/notifications/{id}', MarkNotificationAsRead::class)
                                                                ->name('notifications.update');

    // like / unlike
    Route::post('/post/{post}/like', LikeUnLikeController::class)
                                                                ->name('posts.likes.store');

    // report spams
    Route::post('/posts/{post}/spams', StorePostSpamReportController::class)
                                                                ->name('posts.spams.store');
    Route::post('/threads/{thread}/spams', StoreThreadSpamReportController::class)
                                                                            ->name('threads.spams.store');
    // profile related routes
    Route::get('/account-info', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user/{user:username}', [ProfileController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';
