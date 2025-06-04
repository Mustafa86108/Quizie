@extends('layouts.app')

@section('content')
<style>
    @keyframes floatFade {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade {
        animation: floatFade 0.7s ease-out both;
    }

    select option {
        background-color: #4b0b8a;
        color: white;
    }

    .glow-input:focus {
        box-shadow: 0 0 12px rgba(139, 92, 246, 0.5);
    }
</style>

<div class="min-h-screen pt-24 px-4 pb-16 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white animate-fade">

    <div class="max-w-3xl mx-auto bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl rounded-3xl p-8 space-y-10">

        <!-- Titel -->
        <h1 class="text-3xl font-extrabold text-center text-yellow-300">✏️ Quiz Bewerken</h1>

        <!-- Errors -->
        @if ($errors->any())
            <div class="bg-red-200 text-red-900 p-4 rounded shadow border border-red-400">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulier -->
        <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Titel -->
            <div>
                <label for="title" class="block font-semibold text-white mb-1">🎓 Quiz Titel</label>
                <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" required
                       class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 placeholder:text-purple-200 focus:outline-none glow-input"
                       placeholder="Bijv. Rekenen groep 6">
            </div>

            <!-- Klas -->
            <div>
                <label for="class_id" class="block font-semibold text-white mb-1">🏫 Klas</label>
                <select name="class_id" id="class_id" required
                        class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 glow-input focus:outline-none">
                    <option value="">-- Kies een klas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $quiz->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Boek -->
            <div>
                <label for="book_id" class="block font-semibold text-white mb-1">📘 Boek (optioneel)</label>
                <select name="book_id" id="book_id"
                        class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 glow-input focus:outline-none">
                    <option value="">-- Kies een boek --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ $quiz->book_id == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Cover afbeelding -->
            <div>
                <label for="cover_image" class="block font-semibold text-white mb-1">🖼️ Cover Afbeelding (optioneel)</label>
                <input type="file" name="cover_image" id="cover_image"
                       class="w-full bg-white/10 text-white file:bg-yellow-300 file:text-black border border-purple-400 rounded px-4 py-2 file:px-4 file:py-1 file:rounded">
                @if ($quiz->cover_image)
                    <p class="text-sm mt-2 text-purple-200">📎 Huidige cover:
                        <span class="text-yellow-200">{{ $quiz->cover_image }}</span>
                    </p>
                @endif
            </div>

            <!-- Acties -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('quizzes.index') }}"
                   class="text-white underline hover:text-yellow-300 transition text-sm">
                    ⬅️ Terug naar overzicht
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-purple-900 font-bold px-6 py-2 rounded-full shadow-md hover:scale-105 transition">
                    💾 Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
