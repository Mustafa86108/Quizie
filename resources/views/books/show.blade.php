@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out both;
    }
</style>

<div class="min-h-screen pt-24 pb-20 px-6 bg-gradient-to-br from-[#150050] via-[#3F0071] to-[#FB2576] text-white fade-in-up">
    <div class="max-w-5xl mx-auto bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl rounded-3xl p-8 space-y-10">

        <!-- Boek info -->
        <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start">
            
            <!-- Cover -->
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Boek cover"
                     class="w-48 h-64 object-cover rounded-2xl shadow-lg border-4 border-purple-400">
            @endif

            <!-- Details -->
            <div class="flex-1 text-white">
                <h1 class="text-4xl font-extrabold text-yellow-300 mb-2">{{ $book->title }}</h1>
                <p class="text-purple-100 leading-relaxed">{{ $book->description }}</p>
            </div>
        </div>

        <!-- PDF -->
        <div>
            <h2 class="text-2xl font-bold text-yellow-300 mb-4">📖 Boekinhoud</h2>

            @if($book->pdf_file)
                <iframe src="{{ asset('storage/' . $book->pdf_file) }}#toolbar=1"
                        width="100%" height="600"
                        class="rounded-xl border-2 border-purple-400 shadow-lg bg-white"></iframe>
            @else
                <p class="text-purple-200 italic">📂 Er is geen PDF gekoppeld aan dit boek.</p>
            @endif
        </div>

        <!-- Terug -->
        <div class="text-center">
            <a href="{{ route('books.index') }}"
               class="inline-block bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-bold px-6 py-3 rounded-full shadow-md transition hover:scale-105">
                ⬅️ Terug naar overzicht
            </a>
        </div>
    </div>
</div>
@endsection
