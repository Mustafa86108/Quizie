<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Toon alle boeken.
     */
    public function index()
    {
        $books = Book::withCount('quizzes')->get(); // 👈 belangrijk!
        return view('books.index', compact('books'));
    }

    /**
     * Toon formulier voor het aanmaken van een boek (alleen voor docenten).
     */
    public function create()
    {
        $this->authorizeDocent();
        return view('books.create');
    }

    /**
     * Sla een nieuw boek op in de database (alleen voor docenten).
     */
    public function store(Request $request)
    {
        $this->authorizeDocent();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:8192',
            'pdf_file' => 'required|mimes:pdf|max:10000',
        ]);

        $coverPath = $request->file('cover_image')?->store('covers', 'public');
        $pdfPath = $request->file('pdf_file')?->store('books', 'public');

        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'pdf_file' => $pdfPath,
        ]);

        return redirect()->route('books.index')->with('success', 'Boek succesvol toegevoegd!');
    }

    /**
     * Toon één specifiek boek.
     */
    public function show($id)
    {
        if (!auth()->check()) {
            abort(403, 'Niet ingelogd.');
        }

        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    /**
     * Verwijder een boek en bijhorende bestanden (alleen voor docenten).
     */
    public function destroy($id)
    {
        $this->authorizeDocent();

        $book = Book::findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        if ($book->pdf_file) {
            Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Boek verwijderd!');
    }

    /**
     * Toon formulier om een boek te bewerken (alleen voor docenten).
     */
    public function edit($id)
    {
        $this->authorizeDocent();

        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Werk een bestaand boek bij (alleen voor docenten).
     */
    public function update(Request $request, $id)
    {
        $this->authorizeDocent();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:8192',
            'pdf_file' => 'nullable|mimes:pdf|max:10000',
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->description = $request->description;

        if ($request->hasFile('cover_image')) {
            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $book->pdf_file = $request->file('pdf_file')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Boek is bijgewerkt!');
    }

    /**
     * Controleer of de gebruiker een docent is.
     */
    private function authorizeDocent()
    {
        if (auth()->user()?->role !== 'teacher') {
            abort(403, 'Alleen docenten mogen dit doen.');
        }
    }
}
