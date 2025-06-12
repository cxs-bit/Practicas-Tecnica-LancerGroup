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
