@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeInUp 0.8s ease-out both;
    }
</style>

<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white p-6 fade-in">
    <div class="max-w-3xl bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl shadow-2xl p-10 text-center space-y-8">

        <!-- Titel -->
        <h1 class="text-4xl font-extrabold text-yellow-300">
            📚 Bibliotheek
        </h1>

        <!-- Uitleg -->
        <p class="text-purple-200 text-lg">
            Krijg toegang tot een grote verscheidenheid aan boeken, van studieboeken tot spannende verhalen, allemaal op één plek.
        </p>

        <!-- Placeholder Binnenkort -->
        <div class="bg-white/10 border border-purple-400 rounded-2xl shadow-md p-8 space-y-4">
            <h2 class="text-2xl font-bold text-pink-300">🚧 Binnenkort beschikbaar!</h2>
            <p class="text-gray-200">
                We werken eraan! Binnenkort kun je hier boeken ontdekken, lezen en downloaden.
            </p>
        </div>

    </div>
</div>
@endsection
