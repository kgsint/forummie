<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
    // routes for posts or replies for the thread
    Route::post('/{thread}/posts', [PostController::class, 'store'])
                                                        ->name('posts.store');
    Route::patch('/threads/{thread}/posts/{post}', [PostController::class, 'update'])
                                                                        ->name('posts.update');
    // markdown preview
    Route::post('/markdown-preview', GenerateMarkdownPreview::class)
                                                                    ->name('markdown.preview');
    // profile related routes
    Route::get('/account-info', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
