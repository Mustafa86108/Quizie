@extends('layouts.app')

@section('content')
<style>
body {
    overflow-x: hidden;
}

@keyframes floatBlob {
    0% { transform: translateY(0) rotate(0); }
    50% { transform: translateY(-60px) rotate(20deg); }
    100% { transform: translateY(0) rotate(0); }
}

@keyframes fall {
    0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
    10% { opacity: 0.3; }
    100% { transform: translateY(120vh) rotate(360deg); opacity: 0; }
}

.blob {
    position: absolute;
    opacity: 0.1;
    filter: blur(100px);
    z-index: 0;
}

.blob img {
    width: 800px;
    animation: floatBlob 50s ease-in-out infinite;
}

.falling-object {
    position: absolute;
    font-size: 2rem;
    opacity: 0.2;
    animation: fall linear infinite;
}

.wave {
    position: absolute;
    width: 200%;
    height: 300px;
    background: linear-gradient(90deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.15) 100%);
    transform: rotate(10deg);
    animation: floatBlob 40s ease-in-out infinite;
    z-index: 0;
}

.glass-card {
    background: rgba(255, 255, 255, 0.09);
    backdrop-filter: blur(12px);
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    position: relative;
    cursor: pointer;
}

.glass-card:hover {
    transform: scale(1.1);
    box-shadow: 0 0 50px rgba(255, 0, 255, 0.4);
}

.badge-new {
    position: absolute;
    top: 12px;
    right: 12px;
    background-color: #fb7185;
    color: white;
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 9999px;
    font-weight: bold;
}

.emoji {
    font-size: 4rem;
    animation: bounce 3s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

.mascotte {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2rem;
    padding: 15px 20px;
    backdrop-filter: blur(12px);
    color: white;
    font-size: 1rem;
    animation: floatBlob 12s ease-in-out infinite;
}
</style>

<div class="min-h-screen pt-24 pb-20 px-6 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white relative overflow-hidden">

    <!-- Blobs -->
    <div class="blob" style="top: 5%; left: -10%;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/70/Solid_white.svg">
    </div>
    <div class="blob" style="bottom: 5%; right: -10%;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/70/Solid_white.svg">
    </div>

    <!-- Waves -->
    <div class="wave" style="bottom: 0;"></div>

    <!-- Falling objects -->
    @for ($i = 0; $i < 25; $i++)
        <div class="falling-object" style="
            left: {{ rand(0, 100) }}%;
            animation-duration: {{ rand(12, 40) }}s;
            animation-delay: -{{ rand(0, 20) }}s;
        ">
            @php
                $icons = ['🎈','✨','🎮','📚','🚀','🌟','🎉','📘'];
                echo $icons[array_rand($icons)];
            @endphp
        </div>
    @endfor

    <!-- Welcome text -->
    <div class="text-center mb-16">
        <span class="bg-yellow-400 text-purple-900 py-2 px-5 rounded-full font-bold inline-block animate-pulse">🎉 Speel vandaag & win prijzen!</span>
    </div>

    <div class="max-w-4xl mx-auto text-center mb-14 space-y-3 relative z-10">
        <h1 class="text-5xl font-bold glow-title">👋 Welkom terug, <span class="text-yellow-300">{{ auth()->user()->name }}</span></h1>
        <p class="text-purple-100 text-lg">Wat wil je vandaag doen? 🚀</p>
    </div>

    <!-- Cards -->
    <div class="grid gap-12 sm:grid-cols-2 max-w-4xl mx-auto relative z-10 mb-16">

        <a href="{{ route('quizzes.index') }}" class="glass-card p-10 text-center fade-in-up">
            <span class="badge-new">Nieuw</span>
            <div class="emoji mb-4">🧠</div>
            <h3>Quiz Arena</h3>
            <p>Speel quizzen en verbeter je record!</p>
        </a>

        <a href="{{ route('books.index') }}" class="glass-card p-10 text-center fade-in-up">
            <div class="emoji mb-4">📚</div>
            <h3>Leesruimte</h3>
            <p>Ontdek nieuwe boeken en verhalen.</p>
        </a>

    </div>

<!-- Laatste score -->
<div class="max-w-4xl mx-auto relative z-10 mt-10">
    @if($lastScore)
        <div class="bg-white/10 border border-purple-400 rounded-3xl p-8 text-white shadow-xl backdrop-blur-md space-y-4 animate-fadeIn">
            <h3 class="text-2xl font-bold text-yellow-300">📌 Jouw laatste quiz resultaat</h3>
            <p>📚 <strong>Quiz:</strong> {{ $lastScore->quiz->title }}</p>
            <p>🏆 <strong>Score:</strong> {{ $lastScore->score }} / 5 ({{ round(($lastScore->score / 5) * 100) }}%)</p>
            <p>📅 <strong>Gespeeld op:</strong> {{ $lastScore->created_at->format('d M Y H:i') }}</p>
        </div>
    @else
        <div class="bg-white/10 border border-purple-400 rounded-3xl p-8 text-white shadow-xl backdrop-blur-md animate-fadeIn">
            <p>📚 Je hebt nog geen quiz gespeeld. Begin vandaag nog met leren!</p>
        </div>
    @endif
</div>

    <!-- Mascotte -->
    <div class="mascotte">
        🤖 Hey {{ auth()->user()->name }}, veel succes en veel plezier!
    </div>

</div>
@endsection
