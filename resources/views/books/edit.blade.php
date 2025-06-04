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

<div class="min-h-screen pt-24 pb-20 px-6 bg-gradient-to-br from-[#150050] via-[#3F0071] to-[#FB2576] text-white fade-in">
    <div class="max-w-3xl mx-auto bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl shadow-2xl p-8 space-y-10">

        <!-- Titel -->
        <h1 class="text-4xl font-extrabold text-yellow-300 text-center mb-4">
            📘 Boek Bewerken
        </h1>

        <!-- Foutmeldingen -->
        @if ($errors->any())
            <div class="bg-red-200 text-red-900 p-4 rounded-lg border border-red-400 shadow">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulier -->
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Titel -->
            <div>
                <label class="block font-semibold text-white mb-1">📚 Titel</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}"
                       class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 placeholder:text-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-300"
                       required>
            </div>

            <!-- Beschrijving -->
            <div>
                <label class="block font-semibold text-white mb-1">📝 Beschrijving</label>
                <textarea name="description" rows="4"
                          class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 placeholder:text-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-300">{{ old('description', $book->description) }}</textarea>
            </div>

            <!-- Cover -->
            <div>
                <label class="block font-semibold text-white mb-1">🖼️ Boekcover (optioneel)</label>
                <input type="file" name="cover_image"
                       class="w-full bg-white/10 text-white file:bg-yellow-300 file:text-black file:rounded file:px-4 file:py-1 border border-purple-400 rounded px-3 py-2">
                @if ($book->cover_image)
                    <p class="text-sm mt-2 text-purple-200">📎 Huidige cover: <span class="text-yellow-300">{{ $book->cover_image }}</span></p>
                @endif
            </div>

            <!-- PDF -->
            <div>
                <label class="block font-semibold text-white mb-1">📄 PDF-bestand (optioneel)</label>
                <input type="file" name="pdf_file"
                       class="w-full bg-white/10 text-white file:bg-blue-300 file:text-black file:rounded file:px-4 file:py-1 border border-purple-400 rounded px-3 py-2">
                @if ($book->pdf_file)
                    <p class="text-sm mt-2 text-purple-200">📎 Huidige PDF: <span class="text-blue-300">{{ $book->pdf_file }}</span></p>
                @endif
            </div>

            <!-- Knoppen -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('books.index') }}"
                   class="text-white underline hover:text-yellow-300 transition text-sm flex items-center gap-1">
                    ⬅️ Terug naar boeken
                </a>

                <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold px-6 py-3 rounded-full shadow-lg flex items-center gap-2 transition hover:scale-105">
                    💾 <span>Opslaan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
