@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-200 via-blue-200 to-green-200 px-6 py-12">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-gray-800 text-center">📚 Nieuw Onderwerp</h1>
        <p class="text-gray-600 mt-2 text-center">Voeg een nieuw onderwerp toe voor je studenten.</p>

        <!-- Formulier -->
        <form method="POST" action="{{ route('subjects.store') }}" class="mt-6">
            @csrf

            <div>
                <label for="name" class="block font-medium text-gray-700">Onderwerp Naam</label>
                <input type="text" id="name" name="name" required 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                    + Onderwerp Aanmaken
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('teacher.dashboard') }}" class="text-blue-500 hover:underline">← Terug naar Dashboard</a>
        </div>
    </div>
</div>
@endsection
