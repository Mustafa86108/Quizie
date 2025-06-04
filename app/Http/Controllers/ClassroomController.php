<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;

class ClassroomController extends Controller
{
    public function index()
    {
        $classes = Classroom::where('teacher_id', auth()->id())->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Classroom::create([
            'name' => $request->name,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully!');
    }
}
