@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInZoom {
        from { opacity: 0; transform: scale(0.98); }
        to   { opacity: 1; transform: scale(1); }
    }

    .fade-in {
        animation: fadeInZoom 0.7s ease-out forwards;
    }
</style>

<div class="min-h-screen pt-24 px-6 pb-16 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white fade-in">

    <div class="max-w-5xl mx-auto bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl p-8 space-y-10">

        <!-- Titel -->
        <h2 class="text-3xl font-extrabold text-yellow-300 text-center">
            📋 Quiz: <span class="text-white">{{ $quiz->title }}</span>
        </h2>

        <!-- Feedbackknop -->
        <div class="text-center">
            <a href="{{ route('quizzes.feedback.overview', $quiz->id) }}"
               class="inline-block bg-purple-600 text-white px-6 py-2 rounded-full shadow hover:bg-purple-700 transition text-sm font-semibold">
               💬 Bekijk Feedback van Leerlingen
            </a>
        </div>

        <!-- Gekoppeld Boek -->
        @if($quiz->book)
            <div class="bg-purple-900/30 border border-purple-300 rounded-xl p-6 shadow-md text-white">
                <h3 class="text-xl font-semibold mb-2 text-yellow-300">📖 Gekoppeld Boek</h3>
                <p class="mb-2"><strong>Titel:</strong> {{ $quiz->book->title }}</p>

                @if($quiz->book->cover_image)
                    <img src="{{ asset('storage/' . $quiz->book->cover_image) }}"
                         alt="Boek cover" class="w-32 h-auto mb-3 rounded shadow-md">
                @endif

                @if($quiz->book->pdf_file)
                    <a href="{{ asset('storage/' . $quiz->book->pdf_file) }}" target="_blank"
                       class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 hover:to-indigo-700 text-white font-semibold px-5 py-2 rounded-full shadow transition">
                        📄 Bekijk PDF
                    </a>
                @endif
            </div>
        @else
            <div class="bg-yellow-300/20 text-yellow-100 border border-yellow-400 p-4 rounded-xl text-center shadow">
                📚 Er is nog geen boek gekoppeld aan deze quiz.
            </div>
        @endif

        <!-- Acties -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <a href="{{ route('questions.create', $quiz->id) }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-bold px-6 py-2 rounded-full shadow-md transition">
                ➕ Voeg een vraag toe
            </a>

            <a href="{{ route('questions.index', $quiz->id) }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-6 py-2 rounded-full shadow-md transition">
                📋 Bekijk alle vragen
            </a>
        </div>

        <!-- Vragen -->
        <div class="space-y-4">
            @foreach ($quiz->questions as $index => $question)
                <div class="bg-white/10 border border-purple-300 rounded-xl p-5 shadow-md">
                    <div class="flex justify-between items-center">
                        <p class="font-medium text-white">{{ $index + 1 }}. {{ $question->question_text }}</p>

                        <div class="flex items-center gap-4 text-sm">
                            <a href="{{ route('questions.edit', $question->id) }}"
                               class="text-blue-300 hover:text-blue-400 transition">✏️ Bewerk</a>

                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                                  onsubmit="return confirm('Weet je zeker dat je deze vraag wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 transition">
                                    🗑️ Verwijder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Terug -->
        <div class="text-center pt-6">
            <a href="{{ route('quizzes.index') }}"
               class="text-white underline hover:text-yellow-300 transition text-sm">
                ⬅️ Terug naar quiz overzicht
            </a>
        </div>

    </div>
</div>
@endsection
