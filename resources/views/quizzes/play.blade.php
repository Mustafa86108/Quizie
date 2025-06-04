@extends('layouts.app')

@section('content')
@php
    $questionOrder = session("quiz_order_{$quiz->id}", []);
    $totalQuestions = count($questionOrder);
    $percentage = round(($current / $totalQuestions) * 100);
@endphp

<style>
    .shake {
        animation: shake 0.6s ease-in-out;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        50% { transform: translateX(8px); }
        75% { transform: translateX(-4px); }
        100% { transform: translateX(0); }
    }

    .fade-in {
        animation: fadeIn 0.8s ease-in-out both;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #bomb {
        width: 45px;
        height: 45px;
        background: radial-gradient(circle at top left, #f43f5e, #991b1b);
        border-radius: 9999px;
        box-shadow: 0 0 15px #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        color: white;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 10px #f87171; }
        50% { transform: scale(1.1); box-shadow: 0 0 25px #ef4444; }
        100% { transform: scale(1); box-shadow: 0 0 10px #f87171; }
    }

    .quiz-container {
        min-height: calc(100vh - 120px);
    }

    .option-box {
        transition: all 0.3s ease;
    }

    .peer-checked\:glow {
        box-shadow: 0 0 12px 3px rgba(124, 58, 237, 0.6);
    }
</style>

<div class="max-w-7xl mx-auto px-6 pt-24 quiz-container grid grid-cols-1 md:grid-cols-2 gap-6 fade-in">

    <!-- Boekfragment -->
    <div class="bg-gradient-to-br from-white via-purple-100 to-purple-200 p-6 rounded-2xl shadow-2xl flex flex-col h-full border-l-8 border-purple-700 relative overflow-hidden group transition-all duration-300">
        <div class="absolute top-0 left-0 w-full h-full opacity-5 bg-[url('/images/pattern.svg')] bg-cover bg-no-repeat pointer-events-none"></div>

        <h2 class="text-xl font-extrabold text-purple-900 mb-4 flex items-center gap-3 z-10">
            📖 Boekfragment
        </h2>

        @if ($quiz->book && $quiz->book->pdf_file)
            <div class="relative z-10 flex-1 overflow-hidden rounded-lg border-2 border-purple-300 shadow-md">
                <object 
                    data="{{ asset('storage/' . $quiz->book->pdf_file) }}" 
                    type="application/pdf"
                    class="w-full h-full rounded-lg"
                    style="min-height: 500px;">
                    <p class="text-purple-600 p-4">
                        PDF kan niet weergegeven worden. 
                        <a href="{{ asset('storage/' . $quiz->book->pdf_file) }}" target="_blank" class="text-indigo-600 underline">
                            Open in nieuw tabblad
                        </a>.
                    </p>
                </object>
            </div>
        @else
            <p class="text-purple-500 italic z-10">📭 Geen boek gekoppeld of PDF ontbreekt.</p>
        @endif
    </div>

    <!-- Quizvraag -->
    <div class="bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] p-6 rounded-2xl shadow-2xl text-white flex flex-col justify-between relative quiz-question-container">

        <!-- Voortgang + timer -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex-1 mr-4">
                <div class="w-full bg-purple-900 rounded-full h-3">
                    <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $percentage }}%;"></div>
                </div>
                <p class="text-xs text-right text-purple-200 mt-1">Vraag {{ $current }} van {{ $totalQuestions }}</p>
            </div>
            <div id="bomb">💣 <span id="countdown">30</span></div>
        </div>

        <!-- Vraag -->
        <div>
            <h2 class="text-2xl font-bold mb-2 text-yellow-300">
                Vraag {{ $current }}: {{ $question->question_text }}
            </h2>
            
            @if($question->chapter)
                <p class="text-sm text-purple-200 mb-4">📘 Hoofdstuk {{ $question->chapter }}</p>
            @endif
            


            <div class="mb-4">
                <img src="{{ $question->image ? asset('storage/' . $question->image) : asset('images/default-question.png') }}"
                     alt="Vraagafbeelding"
                     class="rounded-lg shadow-xl max-h-64 object-contain mx-auto">
            </div>
            

            <form id="quiz-form" method="POST" action="{{ route('quizzes.answer', $quiz->id) }}">
                @csrf
                <input type="hidden" name="current" value="{{ $current }}">

                <input type="hidden" name="selectedAnswer" id="selectedAnswer">

                @php
                    $options = [
                        'A' => $question->option_a,
                        'B' => $question->option_b,
                        'C' => $question->option_c,
                        'D' => $question->option_d,
                    ];
                @endphp

                @foreach ($options as $key => $value)
                    <label class="block mb-4">
                        <input type="radio" name="answer" value="{{ $key }}" class="hidden peer" required>
                        <div class="peer-checked:bg-purple-600 peer-checked:glow option-box bg-white text-gray-800 px-4 py-3 rounded-full shadow-md cursor-pointer hover:bg-purple-100 transition-all">
                            <strong>{{ $key }}.</strong> {{ $value }}
                        </div>
                    </label>
                @endforeach

                <button type="submit"
                    class="mt-6 relative w-full py-3 px-6 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-400
                        text-purple-900 text-lg font-extrabold rounded-full shadow-xl hover:shadow-2xl transition-all
                        hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                    <span class="inline-flex items-center gap-2 justify-center">
                        Volgende Vraag
                        <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    const correctSound = new Audio('{{ asset('sounds/children-joy-100078.mp3') }}');
    const wrongSound   = new Audio('{{ asset('sounds/lozing-les.mp3') }}');
    const questionCard = document.querySelector('.quiz-question-container');

    @if(session('play_correct_sound'))
        correctSound.play().catch(() => {});
        confetti({ particleCount: 150, spread: 90, origin: { y: 0.6 } });
    @endif

    @if(session('play_wrong_sound'))
        wrongSound.play().catch(() => {});
        if (questionCard) {
            questionCard.classList.add('shake');
        }
    @endif

    // Timer
    let timeLeft = 30;
    const countdownEl = document.getElementById('countdown');
    const form = document.getElementById('quiz-form');

    const timer = setInterval(() => {
        timeLeft--;
        if (countdownEl) {
            countdownEl.innerText = timeLeft;
        }

        if (timeLeft <= 0) {
            clearInterval(timer);
            document.getElementById('bomb').style.backgroundColor = 'black';
            document.getElementById('bomb').innerText = '💥';
            setTimeout(() => {
                form.submit();
            }, 800);
        }
    }, 1000);
</script>
@endsection
