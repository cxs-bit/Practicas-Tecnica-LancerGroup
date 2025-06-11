<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('greet', function () {
    return response(['message' => 'Hello from Laravel API']);
});


/* BOOKS */
Route::get('/books', [BookController::class, 'index']);



/* AUTHORS */
Route::get('/authors', [AuthorController::class, 'index']);
