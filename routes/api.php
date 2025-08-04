<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/{id}/posts', [UserController::class, 'posts']);
Route::get('/users/{id}/comments', [UserController::class, 'comments']);
Route::resource('users', UserController::class);
Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);
