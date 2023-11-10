<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\GenerateMarkdownPreview;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// forum routes
Route::controller(ForumController::class)->group(function() {
    Route::get('/', 'index')->name('forum.index');
    Route::get('/threads/{thread:slug}', 'show')->name('forum.show');
    Route::post('/threads', 'store')
        ->middleware('auth')
        ->name('forum.store');
});

// markdown preview
Route::post('/markdown-preview', GenerateMarkdownPreview::class)
                                                                ->name('markdown.preview');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/account-info', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
