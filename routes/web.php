<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ForumController::class, 'index'])->name('forum.index');
Route::get('/threads/{thread:slug}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/threads', [ForumController::class, 'store'])
    ->middleware('auth')
    ->name('forum.store');

Route::middleware('auth')->group(function () {
    Route::get('/account-info', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account-info', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-info', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
