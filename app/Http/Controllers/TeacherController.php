<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Toon het dashboard van de docent.
     */
    public function dashboard()
    {
        $teacher = auth()->user();
    
        $subjects = \App\Models\Subject::where('teacher_id', $teacher->id)->get();
        $quizzes = \App\Models\Quiz::whereIn('subject_id', $subjects->pluck('id'))->get();
    
        return view('teacher.dashboard', compact('teacher', 'subjects', 'quizzes'));
    }
}
