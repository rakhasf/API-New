<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::patch('/articles/{id}', [ArticleController::class, 'update'])->middleware(['article.owner']);
    Route::delete('/articles/{id}', [ArticleController::class, 'delete'])->middleware(['article.owner']);

    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('comment.owner');
    Route::delete('/comment/{id}', [CommentController::class, 'delete'])->middleware('comment.owner');
    
});
Route::get('/articles2/{id}', [ArticleController::class, 'show_too']);
