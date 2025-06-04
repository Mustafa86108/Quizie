<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    // Toon het formulier voor een nieuw onderwerp
    public function create()
    {
        return view('subjects.create');
    }

    // Sla het nieuwe onderwerp op in de database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $teacher = auth()->user();
    
        // Controleer of de gebruiker een docent is
        if ($teacher->role !== 'teacher') {
            return redirect()->back()->with('error', 'Je hebt geen rechten om een onderwerp aan te maken.');
        }
    
        // Maak het onderwerp aan en gebruik users.id als teacher_id
        Subject::create([
            'name' => $request->name,
            'teacher_id' => $teacher->id, // Dit verwijst nu correct naar users.id
        ]);
    
        return redirect()->route('teacher.dashboard')->with('success', 'Onderwerp succesvol aangemaakt!');
    }
}