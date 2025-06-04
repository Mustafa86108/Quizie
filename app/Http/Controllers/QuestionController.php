<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Formulier om een nieuwe vraag toe te voegen aan een quiz.
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('questions.create', compact('quiz'));
    }

    
    /**
     * Sla een nieuwe vraag op in de database.
     */
    public function store(Request $request, $quizId)
    {
        $request->validate([
            'question_text' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('question_images', 'public')
            : null;

        Question::create([
            'quiz_id' => $quizId,
            'question_text' => $request->question_text,
            'image' => $imagePath,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_option' => $request->correct_option,
            'chapter' => $request->chapter,
        ]);

        return back()->with('success', 'Vraag toegevoegd!');
    }

    /**
     * Formulier om een bestaande vraag te bewerken.
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    }


    /**
     * Update een bestaande vraag in de database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
            'image' => 'nullable|image|max:2048',
        ]);

        $question = Question::findOrFail($id);

        if ($request->hasFile('image')) {
            $question->image = $request->file('image')->store('question_images', 'public');
        }

        $question->update([
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_option' => $request->correct_option,
            'chapter' => $request->chapter,
        ]);

        return redirect()->route('quizzes.show', $question->quiz_id)
                         ->with('success', 'Vraag succesvol bijgewerkt!');
    }

    /**
     * Verwijder een vraag uit de database.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;

        $question->delete();

        return redirect()->route('quizzes.show', $quizId)
                         ->with('success', 'Vraag succesvol verwijderd!');
    }

    /**
     * Toon een overzicht van alle vragen binnen een quiz.
     */
    public function index($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('questions.index', compact('quiz'));
    }
}
