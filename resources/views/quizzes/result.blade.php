@extends('layouts.app')

@section('content')
<style>
    .fade-in {
        animation: fadeIn 0.6s ease-in-out both;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .badge {
        @apply inline-block px-3 py-1 rounded-full text-sm font-semibold;
    }
</style>

<div class="min-h-screen pt-24 px-4 pb-10 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] fade-in">
    <div class="max-w-3xl mx-auto bg-white p-10 rounded-3xl shadow-2xl border border-purple-100 relative z-10">

        {{--  Titel & Score --}}
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-purple-800 mb-1">📊 Resultaat van "{{ $quiz->title }}"</h2>
            <p class="text-md text-gray-600">Jouw score:</p>
            <p class="text-4xl font-bold {{ $score >= ceil($total/2) ? 'text-green-500' : 'text-red-500' }}">
                {{ $score }} / {{ $total }}
            </p>
        </div>

        {{--  Resultaatbericht --}}
        <div class="text-center mb-10">
            @if ($score >= ceil($total / 2))
                <p class="text-green-600 text-2xl font-bold animate-bounce">🏅 Gefeliciteerd! Je hebt het gehaald!</p>
            @else
                <p class="text-red-500 text-2xl font-bold animate-pulse">😔 Helaas, probeer het opnieuw!</p>
            @endif
        </div>

        {{--  Vraagdetails --}}
        <div class="space-y-5">
            @foreach($details as $index => $item)
                <div class="p-4 rounded-xl shadow-sm border 
                    {{ $item['is_correct'] ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                    <p class="text-md font-semibold text-gray-800 mb-2">
                        📘 Vraag {{ $index + 1 }}: {{ $item['question']->question_text }}
                    </p>
                    <p class="text-sm text-gray-700">
                        🧠 Jouw antwoord: 
                        <span class="badge {{ $item['is_correct'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $item['given'] ?? 'Geen' }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-700 mt-1">
                        ✅ Correct antwoord: 
                        <span class="badge bg-green-100 text-green-700">
                            {{ $item['correct'] }}
                        </span>
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Feedbackformulier --}}
        @if(auth()->user()->role !== 'teacher')
        <div class="mt-12 bg-purple-50 border border-purple-300 p-6 rounded-2xl shadow-md">
            <h3 class="text-xl font-bold text-purple-800 mb-4">🗣️ Wat vond je van deze quiz?</h3>
            <form action="{{ route('quizzes.feedback', $quiz->id) }}" method="POST">
                @csrf

                <!--  Rating -->
                <label class="block mb-2 font-semibold text-purple-700">⭐ Beoordeling (1 t/m 5):</label>
                <select name="rating" required class="w-full bg-white border border-purple-400 rounded px-4 py-2 mb-4 text-gray-800">
                    <option value="">-- Kies een score --</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} ster{{ $i > 1 ? 'ren' : '' }}</option>
                    @endfor
                </select>

                <!--  Feedback -->
                <label class="block mb-2 font-semibold text-purple-700">📝 Jouw feedback (optioneel):</label>
                <textarea name="feedback" rows="4"
                          class="w-full bg-white border border-purple-400 rounded px-4 py-2 text-gray-800 mb-4"
                          placeholder="Schrijf hier wat je vond van de quiz..."></textarea>

                <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full shadow-md hover:scale-105 transition font-semibold">
                    ✅ Feedback Versturen
                </button>
            </form>
        </div>
        @endif

        {{--  Actieknoppen --}}
        <div class="mt-10 flex justify-center gap-4 flex-wrap">
            <a href="{{ route('quizzes.start', $quiz->id) }}"
               class="bg-gradient-to-r from-green-400 to-green-600 text-white font-bold py-2 px-6 rounded-full shadow-lg hover:scale-105 transition-all">
                🔁 Opnieuw Spelen
            </a>
            <a href="{{ route('dashboard') }}"
               class="bg-purple-600 text-white font-semibold py-2 px-6 rounded-full hover:bg-purple-700 transition">
                ⬅️ Terug naar Dashboard
            </a>
        </div>

    </div>
</div>
@endsection

@section('scripts')

<!-- ✅ Confetti library toevoegen -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    const winSound = new Audio('{{ asset("sounds/winner.mp3") }}');
    const loseSound = new Audio('{{ asset("sounds/loser.mp3") }}');

    @if ($score >= ceil($total / 2))
        winSound.play().catch(() => {});
        confetti({ particleCount: 200, spread: 70, origin: { y: 0.5 } });
    @else
        loseSound.play().catch(() => {});
    @endif
</script>
@endsection
