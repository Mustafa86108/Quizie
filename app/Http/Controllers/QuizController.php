<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Book;
use App\Models\ClassModel;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacher')->only([
            'create', 'store', 'edit', 'update', 'destroy', 'createForBook', 'storeForBook'
        ]);
    }

    public function start(Request $request, $quizId)
    {
        $quiz = Quiz::with('book', 'questions')->findOrFail($quizId);
    
        // ✅ Shuffle eenmalig en bewaar in sessie
        $questionOrderKey = "quiz_order_{$quiz->id}";
        if (!session()->has($questionOrderKey)) {
            $shuffled = $quiz->questions->pluck('id')->shuffle()->values()->toArray();
            session([$questionOrderKey => $shuffled]);
        }
    
        // ✅ Bepaal de volgorde
        $questionIds = session($questionOrderKey, []);
        $current = $request->query('question', 1);
        $questionId = $questionIds[$current - 1] ?? null;
    
        // Geen vraag gevonden? Quiz is klaar
        if (!$questionId) {
            return redirect()->route('quizzes.result', ['quiz' => $quizId]);
        }
    
        // ✅ Haal de juiste vraag op
        $question = Question::findOrFail($questionId);
    
        // Blokkeer teruggaan via back-button
        $response = response()->view('quizzes.play', compact('quiz', 'question', 'current'));
        $response->headers->set('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Sat, 01 Jan 2000 00:00:00 GMT');
    
        return $response;
    }

    

    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('quizzes.show', compact('quiz'));
    }

    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $books = Book::all();
        return view('quizzes.create', compact('classes', 'books'));
    }

    public function store(Request $request)
    {
        if ($request->book_id === '') {
            $request->merge(['book_id' => null]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'book_id' => 'nullable|exists:books,id',
            'cover_image' => 'nullable|image|max:6144',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('quiz_covers', 'public');
        }

        $quiz = Quiz::create([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'book_id' => $request->book_id,
            'cover_image' => $coverPath
        ]);

        foreach ($request->questions as $q) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_option' => $q['correct_option'],
                'chapter'        => $q['chapter'] ?? null,
            ]);
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz en vragen succesvol aangemaakt.');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $classes = ClassModel::all();
        $books = Book::all();
        return view('quizzes.edit', compact('quiz', 'classes', 'books'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'book_id' => 'nullable|exists:books,id',
            'cover_image' => 'nullable|image|max:6144',
        ]);

        $quiz = Quiz::findOrFail($id);

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('quiz_covers', 'public');
            $quiz->cover_image = $coverPath;
        }

        $quiz->update([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz verwijderd.');
    }

    public function createForBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('quizzes.create_for_book', compact('book'));
    }

    public function storeForBook(Request $request, $bookId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'book_id' => $bookId,
        ]);

        return redirect()->route('questions.create', $quiz->id)
            ->with('success', 'Quiz voor boek aangemaakt. Voeg nu vragen toe.');
    }
    public function storeFeedback(Request $request, Quiz $quiz)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);
    
        // Opslaan in de pivot-tabel quiz_user
        $quiz->users()->syncWithoutDetaching([
            auth()->id() => [
                'rating' => $request->rating,
                'feedback' => $request->feedback,
            ],
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Bedankt voor je feedback!');
    }
    
        public function feedbackOverview(Quiz $quiz)
    {
        $feedbacks = $quiz->users()
            ->wherePivotNotNull('rating')
            ->withPivot('rating', 'feedback')
            ->get();

            return view('quizzes.feedback_overview', [
                'quiz' => $quiz,
                'feedback' => $feedbacks,
            ]);
    }

    public function showFeedback($quizId)
    {
        $quiz = Quiz::with('users')->findOrFail($quizId);

        // Alleen gebruikers met feedback
        $feedback = $quiz->users()->wherePivotNotNull('rating')->get();

        return view('quizzes.feedback_overview', [
            'quiz' => $quiz,
            'feedback' => $feedback,
        ]);
    }

    public function answer(Request $request, $quizId)
{
    $quiz = Quiz::findOrFail($quizId); // <-- Geen 'with' nodig hier

    $current = $request->input('current');
    $answer = $request->input('answer');

    // Haal de volgorde uit de sessie
    $shuffledIds = session("quiz_order_{$quizId}");
    $questionId = $shuffledIds[$current - 1] ?? null;

    // Als de vraag-ID niet geldig is, ga naar resultaat
    if (!$questionId) {
        return redirect()->route('quizzes.result', ['quiz' => $quizId]);
    }

    // 🔥 Belangrijk: Haal de vraag direct uit de DB!
    $question = \App\Models\Question::findOrFail($questionId);

    // Haal eerdere antwoorden op uit sessie
    $answers = session()->get('quiz_answers', []);

    // Sla het antwoord op als het nog niet is gegeven
    if (!isset($answers[$question->id])) {
        $answers[$question->id] = $answer;
        session(['quiz_answers' => $answers]);

        // Speel geluid op basis van juist/onjuist antwoord
        session()->flash(
            $answer === $question->correct_option ? 'play_correct_sound' : 'play_wrong_sound',
            true
        );
    }

    $next = $current + 1;

    // Als er nog vragen zijn, ga naar volgende, anders naar resultaat
    return isset($shuffledIds[$next - 1])
        ? redirect()->route('quizzes.start', ['quiz' => $quizId, 'question' => $next])
        : redirect()->route('quizzes.result', ['quiz' => $quizId]);
}
    


public function result($quizId)
{
    $quiz = Quiz::with('questions')->findOrFail($quizId);
    $answers = session('quiz_answers', []);
    $shuffledIds = session("quiz_order_{$quizId}", []);
    $questions = $quiz->questions->keyBy('id');

    $score = 0;
    $details = [];

    foreach ($shuffledIds as $questionId) {
        $question = $questions[$questionId] ?? null;

        if (!$question) continue;

        $given = $answers[$questionId] ?? null;

        $details[] = [
            'question' => $question,
            'given' => $given,
            'correct' => $question->correct_option,
            'is_correct' => $given === $question->correct_option,
        ];

        if ($given === $question->correct_option) {
            $score++;
        }
    }

    session()->forget("quiz_order_{$quizId}");
    session()->forget('quiz_answers');
    session()->put('quiz_finished_' . $quizId, true);

    $total = count($shuffledIds);

    //  Score opslaan in database
    \App\Models\Score::create([
        'user_id' => auth()->id(),
        'quiz_id' => $quiz->id,
        'score' => $score,
    ]);

    return view('quizzes.result', compact('quiz', 'score', 'total', 'details'));
}

}