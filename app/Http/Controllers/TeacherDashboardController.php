<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Classroom;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user(); // Get logged-in teacher
    
        // Fetch subjects created by the teacher
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
    
        // Fetch quizzes created by the teacher
        $quizzes = Quiz::where('teacher_id', $teacher->id)->get();
    
        // Fetch classes belonging to this teacher, including students
        $classes = Classroom::where('teacher_id', $teacher->id)->with('students')->get();
    
        // Debugging output
        dd($classes); // This will dump and die with the classes data
    
        return view('dashboard', compact('subjects', 'quizzes', 'classes'));
    }
}
