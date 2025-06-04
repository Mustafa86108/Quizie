@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        animation: fadeUp 0.8s ease-out forwards;
    }
</style>

<div class="min-h-screen pt-24 px-4 pb-20 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white fade-in-up">

    <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl shadow-2xl p-8 space-y-8">

        <!-- Titel -->
        <h2 class="text-3xl font-extrabold text-yellow-300 text-center">
            ✏️ Vraag Bewerken
        </h2>

        <!-- Validatie Fouten -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl shadow">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulier -->
        <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Vraagtekst -->
            <div>
                <label for="question_text" class="block font-medium mb-1 text-white">🧠 Vraag</label>
                <textarea name="question_text" id="question_text" rows="3" required
                          class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300">{{ $question->question_text }}</textarea>
            </div>

            <!-- Afbeelding -->
            <div>
                <label for="image" class="block font-medium mb-1 text-white">📷 Afbeelding (optioneel)</label>
                <input type="file" name="image" id="image"
                       class="w-full bg-white/10 text-white file:bg-yellow-300 file:text-black file:rounded file:px-4 file:py-1 border border-purple-400 rounded px-3 py-2">
                @if ($question->image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $question->image) }}"
                             alt="Vraag afbeelding" class="rounded-xl shadow-lg max-h-40 mx-auto">
                    </div>
                @endif
            </div>

            <!-- Antwoordopties -->
            <div class="grid grid-cols-2 gap-6">
                @foreach (['A', 'B', 'C', 'D'] as $opt)
                    <div>
                        <label for="option_{{ strtolower($opt) }}" class="block font-medium text-white">Optie {{ $opt }}</label>
                        <input type="text" name="option_{{ strtolower($opt) }}" id="option_{{ strtolower($opt) }}"
                               value="{{ $question->{'option_' . strtolower($opt)} }}"
                               class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2" required>
                    </div>
                @endforeach
            </div>

            <!-- Correcte Optie -->
            <div>
                <label for="correct_option" class="block font-medium text-white">✅ Correct Antwoord</label>
                <select name="correct_option" id="correct_option"
                        class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2" required>
                    <option value="">-- Kies een optie --</option>
                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                        <option value="{{ $opt }}" {{ $question->correct_option == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <!--  Hoofdstuk -->
            <div>
                <label for="chapter" class="block font-medium text-white">📘 Hoofdstuk (optioneel)</label>
                <input type="number" name="chapter" id="chapter"
                    value="{{ old('chapter', $question->chapter) }}"
                    placeholder="Bijv. 2"
                    class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2 placeholder:text-purple-300">
            </div>
            <!-- Opslaan Knop -->
            <div class="pt-6 text-center">
                <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:to-yellow-600 text-purple-900 font-bold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                    💾 Opslaan
                </button>
            </div>
        </form>

        <!-- Terug Link -->
        <div class="text-center pt-4">
            <a href="{{ route('quizzes.show', $question->quiz_id) }}" class="text-white underline hover:text-yellow-300 transition text-sm">
                ⬅️ Terug naar Quiz
            </a>
        </div>

    </div>
</div>
@endsection
