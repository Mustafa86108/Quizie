@extends('layouts.app')

@section('content')
<div class="min-h-screen pt-24 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] px-6 py-14 text-white">

    <div class="max-w-5xl mx-auto text-center space-y-14 animate-fade-in">
        
        <!-- Titel -->
        <h1 class="text-4xl sm:text-5xl font-extrabold text-yellow-300 drop-shadow-xl">
            Over TechKicks Bibliotheek
        </h1>

        <!-- Uitleg -->
        <div class="text-left space-y-6 text-lg leading-relaxed text-purple-200">
            <p>
                📘 <strong class="text-yellow-400">Wat is TechKicks Bibliotheek?</strong><br>
                TechKicks is een interactieve digitale leeromgeving vol quizzen, video's en plezier. Hier leren, ontdekken en spelen hand in hand gaan.
            </p>

            <p>
                👩‍🏫 <strong class="text-yellow-400">Voor Docenten</strong><br>
                Docenten kunnen quizzen beheren, statistieken bekijken, en feedback geven aan Leerlingen . Perfect voor klassikaal én zelfstandig leren.
            </p>

            <p>
                🧑‍🎓 <strong class="text-yellow-400">Voor Leerlingen </strong><br>
                Leerlingen  ontdekken spannende boeken, maken quizzen en verzamelen badges. Interactief leren wordt leuk én beloond.
            </p>
        </div>

        <!-- Hoe werkt het -->
        <div class="text-left space-y-4">
            <h2 class="text-2xl font-bold text-pink-300">🚀 Hoe werkt het?</h2>
            <ul class="list-disc pl-6 space-y-2 text-purple-200 text-base">
                <li><strong class="text-yellow-400">1.</strong> Log in of registreer voor toegang tot quizzen en bibliotheek.</li>
                <li><strong class="text-yellow-400">2.</strong> Verken de boeken en video's.</li>
                <li><strong class="text-yellow-400">3.</strong> Doe interactieve quizzen en verzamel badges.</li>
                <li><strong class="text-yellow-400">4.</strong> Speel het Woordspel 🎮</li>
                <li><strong class="text-yellow-400">5.</strong> Verdien XP, level up en behaal je Superster badge ✨</li>
            </ul>
        </div>

        <!-- Video's -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-indigo-300">🎥 Video Tutorials</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe class="w-full h-full rounded-xl shadow-2xl border border-purple-400" src="https://www.youtube.com/embed/15GySyrXDo4" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe class="w-full h-full rounded-xl shadow-2xl border border-purple-400" src="https://www.youtube.com/embed/15GySyrXDo4" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="flex flex-col sm:flex-row gap-5 justify-center pt-8">
            <a href="{{ route('register') }}"
               class="bg-green-400 hover:bg-green-500 text-purple-900 font-bold px-6 py-3 rounded-full shadow-lg transition hover:scale-105">
                📝 Aanmelden
            </a>
            <a href="{{ route('login') }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-bold px-6 py-3 rounded-full shadow-lg transition hover:scale-105">
                🔐 Inloggen
            </a>
        </div>
    </div>

</div>
@endsection
