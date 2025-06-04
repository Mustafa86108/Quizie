@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 px-4 grid grid-cols-1 md:grid-cols-2 gap-6">

    {{--  Boek als PDF (indien beschikbaar) --}}
    @if($quiz->book && $quiz->book->pdf_path)
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">📖 Boek: {{ $quiz->book->title }}</h2>
            <iframe src="{{ asset('storage/' . $quiz->book->pdf_path) }}" class="w-full h-[600px] rounded border"></iframe>
        </div>
    @endif

    {{--  Vraag --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-orange-600 mb-4">
            Vraag {{ $current }} van {{ $quiz->questions->count() }}
        </h2>

        <form method="POST" action="{{ route('quizzes.answer', $quiz->id) }}">
            @csrf
            <input type="hidden" name="current" value="{{ $current }}">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                {{ $question->question_text }}
            </h3>

            @if($question->image)
                <img src="{{ asset('storage/' . $question->image) }}" alt="Vraag afbeelding"
                     class="w-64 mb-4 rounded border">
            @endif

            <div class="space-y-3">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="answer" value="A" class="text-blue-600" required>
                    <span>A. {{ $question->option_a }}</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="answer" value="B" class="text-blue-600">
                    <span>B. {{ $question->option_b }}</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="answer" value="C" class="text-blue-600">
                    <span>C. {{ $question->option_c }}</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="answer" value="D" class="text-blue-600">
                    <span>D. {{ $question->option_d }}</span>
                </label>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow">
                    {{ $current < $quiz->questions->count() ? 'Volgende ➡️' : '✅ Afronden' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
