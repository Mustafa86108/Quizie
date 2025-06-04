<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    UserController,
    TeacherController,
    ClassController,
    SubjectController,
    QuizController,
    QuestionController,
    ScoreController,
    PageController,
    BookController
};

/*
|--------------------------------------------------------------------------
| 🌐 Web Routes
|--------------------------------------------------------------------------
*/

//  Publieke homepage
Route::get('/', fn () => view('welcome'));

//  Geverifieerde gebruikers (Leerling & docent)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

// Profielbeheer (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  Algemene toegang voor alle gebruikers
    Route::get('/library', [PageController::class, 'exploreLibrary'])->name('library.explore');
    Route::get('/collaboration-projects', [PageController::class, 'collaborationProjects'])->name('collaboration.projects');
    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');

    Route::resource('/classes', ClassController::class)->except(['show']);
});

Route::get('/interactive-learning', [PageController::class, 'interactiveLearning'])->name('interactive.learning');

//  Alleen voor docenten
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

    // Vakken en klassen
    Route::resource('/subjects', SubjectController::class);

    // Volledige quizbeheer
    Route::resource('/quizzes', QuizController::class)->except(['show']);
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

    // Quiz aanmaken voor boek
    Route::get('/books/{book}/quiz/create', [QuizController::class, 'createForBook'])->name('quiz.create.for.book');
    Route::post('/books/{book}/quiz/store', [QuizController::class, 'storeForBook'])->name('quiz.store.for.book');

    // Vraagbeheer (voor docenten)
    Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::delete('/questions/bulk-delete', [QuestionController::class, 'bulkDelete'])->name('questions.bulkDelete');

    // Boekbeheer (alleen docenten)
    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});

// Iedereen mag quizzen bekijken en spelen
Route::middleware(['auth'])->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/answer', [QuizController::class, 'answer'])->name('quizzes.answer');
    Route::get('/quizzes/{quiz}/result', [QuizController::class, 'result'])->name('quizzes.result');
    

    //  Feedback versturen (door Leerlingen)
    Route::post('/quizzes/{quiz}/feedback', [QuizController::class, 'storeFeedback'])->name('quizzes.feedback');

    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});

//  Routes ALLEEN voor docenten (maken, bewerken, verwijderen)
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/feedback', [QuizController::class, 'feedbackOverview'])->name('quizzes.feedback.overview');


});

//  Boekoverzicht mag iedereen zien
Route::get('/books', [BookController::class, 'index'])->name('books.index');

//  Auth routes (login, registratie, wachtwoord, etc.)
require __DIR__ . '/auth.php';
