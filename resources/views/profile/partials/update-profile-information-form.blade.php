@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out both;
    }
</style>

<div class="min-h-screen pt-24 pb-16 px-6 bg-gradient-to-br from-[#3F0071] via-[#7B2CBF] to-[#C9184A] text-white">
    <div class="max-w-3xl mx-auto bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl shadow-2xl p-8 fade-in">

        <!-- Titel -->
        <h1 class="text-4xl font-extrabold text-center text-yellow-300 mb-4">👤 Mijn Profiel</h1>
        <p class="text-center text-purple-200 text-sm mb-6">Beheer je account en bekijk je quizresultaten.</p>

        <!-- Profielfoto + Rol -->
        <div class="flex flex-col items-center space-y-4 mb-10">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                 class="w-28 h-28 object-cover rounded-full border-4 border-purple-400 shadow-md transition-transform duration-300 hover:scale-105" alt="Profielfoto">
            <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
            <span class="text-sm bg-purple-700 px-3 py-1 rounded-full text-white font-medium shadow">🔑 Rol: {{ ucfirst(Auth::user()->role) }}</span>
        </div>

        <!-- Activiteiten -->
        <div class="mb-10 space-y-3">
            <h3 class="text-lg font-semibold text-yellow-300">📌 Laatste Activiteit</h3>
            <ul class="text-sm text-purple-200 space-y-1">
                <li>📅 Laatste login: {{ Auth::user()->last_login ?? 'Zojuist' }}</li>
                <li>✅ Aantal gemaakte quizzen: <strong>5</strong></li> {{-- Dummy data --}}
            </ul>
        </div>

        <!-- Quizresultaten -->
        <div class="mb-10">
            <h3 class="text-lg font-semibold text-yellow-300 mb-2">🏆 Mijn Scores</h3>
            <div class="bg-purple-800/30 p-4 rounded-lg shadow space-y-1">
            </div>
        </div>

        <!-- Profiel bijwerken -->
        <div>
            <h3 class="text-lg font-semibold text-yellow-300 mb-2">🔧 Bijwerken Profiel</h3>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                @csrf
                @method('PATCH')

                <!-- Naam -->
                <div>
                    <label class="block text-sm text-white mb-1" for="name">Naam</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                           class="w-full bg-white/10 border border-purple-400 text-white rounded px-4 py-2 placeholder:text-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm text-white mb-1" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                           class="w-full bg-white/10 border border-purple-400 text-white rounded px-4 py-2 placeholder:text-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Profielfoto -->
                <div>
                    <label class="block text-sm text-white mb-1" for="profile_picture">Profielafbeelding</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                           class="w-full bg-white/10 text-white file:bg-yellow-300 file:text-black file:rounded file:px-4 file:py-1 border border-purple-400 rounded px-3 py-2">
                    <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                </div>

                <!-- Opslaan -->
                <div class="flex justify-end gap-4">
                    <button type="submit"
                            class="bg-gradient-to-r from-yellow-400 to-orange-400 text-purple-900 font-bold px-6 py-2 rounded-full shadow-lg hover:scale-105 transition">
                        💾 Opslaan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-300 self-center animate-pulse">✅ Profiel opgeslagen!</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
