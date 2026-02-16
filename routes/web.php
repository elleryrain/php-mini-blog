<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts', [PostController::class, 'index']);


Route::middleware('auth')->group(function (): void {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::match(['put', 'patch'], '/posts/{post:slug}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->name('posts.destroy');
});
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
