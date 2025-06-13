<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

// BOOKS
Route::get('/books', [BookController::class, 'index']);

// AUTHORS
Route::resource('/authors', AuthorController::class);
// Route::get('/authors', [AuthorController::class, 'index']);
// Route::post('/authors', [AuthorController::class, 'store']);
// Route::get('/authors/{id}', [AuthorController::class, 'show']);
// Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);
// Route::put('/authors/{id}', [AuthorController::class, 'update']);
