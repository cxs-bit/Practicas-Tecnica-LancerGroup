<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::get();
        $books = Book::with('authors')->get();
        return Inertia::render('Books', [
            'books' => $books,
            'authors' => $authors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'edition' => 'required|string|max:255',
            'publish_date' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $book = Book::create($request->only(['name', 'edition', 'publish_date']));
        $book->authors()->sync($request->authors);
        return redirect()->route('books.index')->with('success', 'Libro creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['authors' => function ($query) {
            $query->withTrashed();
        }])->find($id);
        return Inertia::render('Books/Show', [
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'edition' => 'required|string|max:255',
            'publish_date' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->only(['name', 'edition', 'publish_date']));
        $book->authors()->sync($request->authors);

        return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return Inertia::location(route('books.index'));
    }
}
