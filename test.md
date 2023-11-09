# Primary Title for markdown 
Nostra at, nam commodo gravida magnis. Faucibus neque. Litora bibendum praesent tristique nascetur. Non inceptos elementum. Eu tincidunt hymenaeos Porttitor.
Varius ullamcorper nisi diam. Nisl libero laoreet fusce, eros magna erat pretium pulvinar donec. Tortor aptent nostra dolor condimentum facilisi curabitur tellus metus quam proin pretium id sollicitudin Curae; dapibus.

## Secondary Title for markdown
Scelerisque id aliquet hac ipsum morbi, sociosqu arcu sociis proin malesuada. Curae; aptent venenatis sollicitudin eget.

Suspendisse vivamus maecenas. Eleifend per hac congue nisi bibendum molestie. Luctus nec augue et elementum mollis suscipit tempus non.

Metus tempor commodo fusce, facilisi eget senectus risus risus pulvinar neque viverra donec integer nibh.

```php 
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

```

### Tertiary Title
Nostra at, nam commodo gravida magnis. Faucibus neque. Litora bibendum praesent tristique nascetur. Non inceptos elementum. Eu tincidunt hymenaeos Porttitor.
Varius ullamcorper nisi diam. Nisl libero laoreet fusce, eros magna erat pretium pulvinar donec. Tortor aptent nostra dolor condimentum facilisi curabitur tellus metus quam proin pretium id sollicitudin Curae; dapibus.
Scelerisque id aliquet hac ipsum morbi, sociosqu arcu sociis proin malesuada. Curae; aptent venenatis sollicitudin eget.

Suspendisse vivamus maecenas. Eleifend per hac congue nisi bibendum molestie. Luctus nec augue et elementum mollis suscipit tempus non.

Metus tempor commodo fusce, facilisi eget senectus risus risus pulvinar neque viverra donec integer nibh.
