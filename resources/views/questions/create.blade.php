@extends('layouts.app')

@section('content')
<style>
    @keyframes slideFade {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-slide {
        animation: slideFade 0.8s ease-out forwards;
    }

    select option {
        background-color: #4b0b8a;
        color: white;
    }

    .glow-input:focus {
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.6);
    }
</style>

<div class="min-h-screen pt-24 px-6 pb-20 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white animate-slide">

    <div class="max-w-3xl mx-auto bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl p-8 space-y-10">

        <!-- Titel -->
        <h2 class="text-3xl font-extrabold text-center text-yellow-300">📝 Voeg een vraag toe</h2>
        <p class="text-center text-purple-200 text-sm mb-6">Aan quiz: <strong class="text-white">{{ $quiz->title }}</strong></p>

        <!-- Succesmelding -->
        @if (session('success'))
            <div class="bg-green-300 bg-opacity-20 text-green-100 border border-green-400 p-4 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulier -->
        <form action="{{ route('questions.store', $quiz->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Vraagtekst -->
            <div>
                <label for="question_text" class="block font-semibold text-white mb-1">🧠 Vraag</label>
                <textarea name="question_text" id="question_text" rows="3" required
                          class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 placeholder:text-purple-300 glow-input focus:outline-none"
                          placeholder="Bijv. Wat is de hoofdstad van Frankrijk?"></textarea>
            </div>

            <!-- Afbeelding upload -->
            <div>
                <label for="image" class="block font-semibold text-white mb-1">📷 Afbeelding (optioneel)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-2 file:bg-yellow-300 file:text-black file:rounded file:px-4 file:py-1">
            </div>

            <!-- Antwoorden -->
            <div class="grid grid-cols-2 gap-6">
                @foreach(['A', 'B', 'C', 'D'] as $opt)
                <div>
                    <label for="option_{{ strtolower($opt) }}" class="block font-semibold text-white mb-1">🔹 Optie {{ $opt }}</label>
                    <input type="text" name="option_{{ strtolower($opt) }}" id="option_{{ strtolower($opt) }}" required
                           class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-2 placeholder:text-purple-300 glow-input focus:outline-none"
                           placeholder="Bijv. Antwoord {{ $opt }}">
                </div>
                @endforeach
            </div>

            <!-- Correct Antwoord -->
            <div>
                <label for="correct_option" class="block font-semibold text-white mb-1">✅ Correct Antwoord</label>
                <select name="correct_option" id="correct_option" required
                        class="w-full bg-purple-900 text-white border border-purple-400 rounded px-4 py-3 glow-input focus:outline-none">
                    <option value="">-- Kies het juiste antwoord --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
            <!-- Hoofdstuk nummer -->
            <div>
                <label for="chapter" class="block font-semibold text-white mb-1">📘 Hoofdstuk (optioneel)</label>
                <input type="number" name="chapter" id="chapter"
                    class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 placeholder:text-purple-300 glow-input focus:outline-none"
                    placeholder="Bijv. 1">
            </div>

            <!-- Submit knop -->
            <div class="text-center pt-4">
                <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-purple-900 font-bold px-8 py-3 rounded-full shadow-xl transform transition hover:scale-105">
                    ➕ Vraag Toevoegen
                </button>
            </div>
        </form>

        <!-- Terug naar quiz -->
        <div class="text-center pt-6">
            <a href="{{ route('quizzes.show', $quiz->id) }}"
               class="text-white underline hover:text-yellow-300 transition">
                ⬅️ Terug naar Quiz
            </a>
        </div>
    </div>
</div>
@endsection
