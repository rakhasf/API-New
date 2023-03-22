<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware(['post.owner']);
    Route::delete('/posts/{id}', [PostController::class, 'delete'])->middleware(['post.owner']);

    Route::post('/comment', [CommentController::class, 'store']);
    Route::post('/comment/{id}', [CommentController::class, 'update'])->middleware('comment.owner');
    
});
Route::get('/posts2/{id}', [PostController::class, 'show_too']);
