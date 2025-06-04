<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher; // Missing import for Teacher model
use App\Models\Score;

class UserController extends Controller
{
    public function dashboard()
{
    if (auth()->user()->role === 'teacher') {
        $teachers = Teacher::all(); // Load teachers
        return view('teachers.dashboard', compact('teachers'));
    } elseif (auth()->user()->role === 'student') {
        // ✅ Laad laatste gespeelde quiz score
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $lastScore = $user->scores()->with('quiz')->latest()->first();

        return view('student.dashboard', compact('lastScore'));
    }

    abort(403, 'Unauthorized access.');
}
    
}
