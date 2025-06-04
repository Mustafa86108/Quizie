@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeSlide 0.7s ease-out forwards;
    }

    .feedback-card {
        background: rgba(255, 255, 255, 0.9);
        border-left: 8px solid #ddd;
        border-radius: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feedback-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(0,0,0,0.15);
    }

    .feedback-rating {
        font-size: 1.25rem;
    }

    .rating-5 { color: #22c55e; } /* Groen */
    .rating-4 { color: #84cc16; } /* Licht groen */
    .rating-3 { color: #facc15; } /* Geel */
    .rating-2 { color: #f97316; } /* Oranje */
    .rating-1 { color: #ef4444; } /* Rood */
</style>

<div class="min-h-screen pt-24 px-6 pb-20 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white fade-in">
    <div class="max-w-4xl mx-auto">

        <!-- Titel -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-yellow-300 mb-3">📄 Feedback op "{{ $quiz->title }}"</h2>
            <p class="text-purple-100">Bekijk wat andere leerlingen vonden van deze quiz.</p>
        </div>

        <!-- Feedback -->
        @forelse ($feedback as $item)
            @php
                $ratingClass = 'rating-' . $item->pivot->rating;
            @endphp
            <div class="feedback-card {{ $ratingClass }}">
                <p class="text-xl font-bold text-indigo-900 mb-3">👤 {{ $item->name }}</p>

                <p class="feedback-rating mb-3 {{ $ratingClass }}">
                    @for ($i = 0; $i < $item->pivot->rating; $i++)
                        ⭐
                    @endfor
                    <span class="text-gray-500 text-sm">({{ $item->pivot->rating }} / 5)</span>
                </p>

                @if($item->pivot->feedback)
                    <p class="text-gray-700 text-lg">💬 "{{ $item->pivot->feedback }}"</p>
                @else
                    <p class="text-gray-400 italic">Geen extra feedback gegeven.</p>
                @endif
            </div>
        @empty
            <div class="text-center bg-white/20 text-white py-8 px-6 rounded-xl border border-white/30">
                📭 Nog geen feedback ontvangen voor deze quiz.
            </div>
        @endforelse

        <!-- Terug knop -->
        <div class="text-center mt-12">
            <a href="{{ route('quizzes.index') }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-bold py-3 px-6 rounded-full shadow-lg transition hover:scale-105">
                ⬅️ Terug naar alle quizzen
            </a>
        </div>

    </div>
</div>
@endsection
