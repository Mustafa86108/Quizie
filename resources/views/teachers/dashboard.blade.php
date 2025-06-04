@extends('layouts.app')

@section('content')
<style>
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-up {
        animation: fade-up 0.8s ease-out forwards;
    }

    .glow:hover {
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2), 0 0 10px rgba(255, 255, 255, 0.2);
        transform: translateY(-4px);
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] px-4 py-16 text-white flex flex-col items-center justify-center space-y-10">

    <!-- Hero: Welkom -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 max-w-2xl w-full text-center fade-up shadow-xl">
        <h1 class="text-4xl font-extrabold text-white mb-3"> Welkom terug, {{ auth()->user()->name }}!</h1>
        <p class="text-purple-200 mb-2 text-lg">Je hebt de controle over alle quizzen en boeken </p>

        <span class="inline-block bg-yellow-400 text-purple-900 text-xs font-bold px-3 py-1 rounded-full shadow mt-3 tracking-wide uppercase">
            👨‍🏫 Docent Dashboard
        </span>
    </div>

    <!-- Acties -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl w-full fade-up">

        <!-- Nieuwe Quiz -->
        <a href="{{ route('quizzes.create') }}"
           class="glow bg-white/10 hover:bg-white/20 border border-purple-300 text-white rounded-xl p-6 transition-all shadow-xl text-center flex flex-col items-center justify-center space-y-3">
            <div class="text-5xl">📝</div>
            <h3 class="text-xl font-semibold">Nieuwe Quiz</h3>
            <p class="text-sm text-purple-200">Maak een quiz voor je Leerlingen .</p>
        </a>

        <!-- Nieuw Boek -->
        <a href="{{ route('books.create') }}"
           class="glow bg-white/10 hover:bg-white/20 border border-yellow-300 text-white rounded-xl p-6 transition-all shadow-xl text-center flex flex-col items-center justify-center space-y-3">
            <div class="text-5xl">📚</div>
            <h3 class="text-xl font-semibold">Nieuw Boek</h3>
            <p class="text-sm text-purple-200">Voeg een nieuw boek toe aan je collectie.</p>
        </a>
    </div>

    <!-- Footer badge (optioneel) -->
    <p class="text-sm text-purple-300 mt-8 italic">TechKicks Docent Dashboard</p>
</div>
@endsection
