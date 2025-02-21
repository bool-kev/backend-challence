<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\BlogController;
use App\Http\Controllers\V1\CommentaireController;
use App\Http\Controllers\V1\LikeController;
use App\Http\Controllers\V1\ThemeController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("V1")->namespace("App\Http\Controllers\V1")->middleware('auth:sanctum')->group(function(){
    Route::post('user', [AuthController::class, 'store'])->withoutMiddleware('auth:sanctum')->name('register');
    Route::post('user/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum')->name("login");
    Route::post('user/logout', [AuthController::class, 'logout'])->name("logout");
    Route::get('user', [AuthController::class, 'me'])->name("me");

    Route::apiResource('blog', BlogController::class)->only(['index','show','store','update','destroy']);
    Route::post("blog/{blog}/commentaire", [CommentaireController::class, 'store'])->name("blog.comment.create");
    Route::post("blog/{blog}/like", [LikeController::class, 'toggle'])->name("blog.like.toggle");
    Route::apiResource('theme', ThemeController::class)->except(['create','edit','show']);
});
