<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::patch('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::post('/posts/{post}/vote', [VoteController::class, 'toggle'])
        ->name('posts.vote');

    Route::get(
        '/communities/{community}/posts/create',
        [PostController::class, 'createForCommunity']
    )
        ->name('communities.posts.create');
});

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/posts/{post}/files/{index}', [PostController::class, 'downloadFile'])
    ->name('posts.files.download');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('communities', CommunityController::class)
            ->only([
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]);
    });

Route::get('/communities', [CommunityController::class, 'index'])
    ->name('communities.index');

Route::get('/communities/{community}', [CommunityController::class, 'show'])
    ->name('communities.show');
