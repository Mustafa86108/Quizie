@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    select option {
        background-color: #4b0b8a;
        color: white;
    }
</style>

<div class="min-h-screen pt-24 px-4 pb-20 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white fade-in-up">
    <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl p-8 space-y-10">

        <h2 class="text-3xl font-extrabold text-center text-yellow-300 mb-2">✨ Nieuwe Quiz Aanmaken</h2>
        <p class="text-center text-purple-200 text-sm">Vul de quizinformatie in en voeg je vragen toe. Let’s go! 🚀</p>

        @if ($errors->any())
            <div class="bg-red-300 bg-opacity-20 text-red-100 border border-red-400 p-4 rounded shadow">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Titel -->
            <div>
                <label for="title" class="block font-semibold mb-1 text-white">🎓 Quiz Titel</label>
                <input type="text" name="title" id="title" required
                       class="w-full bg-white/10 text-white border border-purple-400 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300 placeholder:text-purple-300"
                       placeholder="Bijv. Tijden & Klokken">
            </div>

            <!-- Klas -->
            <div>
                <label for="class_id" class="block font-semibold mb-1 text-white">🏫 Klas</label>
                <select name="class_id" id="class_id" required
                        class="w-full bg-purple-900 text-white border border-purple-400 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="">-- Kies een klas --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Boek -->
            <div>
                <label for="book_id" class="block font-semibold mb-1 text-white">📖 Boek (optioneel)</label>
                <select name="book_id" id="book_id"
                        class="w-full bg-purple-900 text-white border border-purple-400 rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="">-- Kies een boek --</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Afbeelding -->
            <div>
                <label for="cover_image" class="block font-semibold mb-1 text-white">🖼️ Cover Afbeelding</label>
                <input type="file" name="cover_image" id="cover_image"
                       class="w-full bg-white/10 text-white file:bg-yellow-300 file:text-black file:rounded file:px-4 file:py-1 border border-purple-400 rounded px-3 py-2">
            </div>

            <!-- Vragen -->
            <hr class="border-purple-400 opacity-30">
            <h3 class="text-2xl font-bold text-yellow-300 mb-2">🧠 Vragen toevoegen</h3>

            <div id="question-wrapper" class="space-y-6">
                <!-- Eerste vraag -->
                <div class="bg-white/5 border border-purple-400 rounded-xl p-5 space-y-4 shadow-lg">
                    <label class="block font-medium text-white">Vraag</label>
                    <textarea name="questions[0][question_text]" required
                              class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2 focus:outline-none"></textarea>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="questions[0][option_a]" placeholder="Optie A" required
                               class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                        <input type="text" name="questions[0][option_b]" placeholder="Optie B" required
                               class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                        <input type="text" name="questions[0][option_c]" placeholder="Optie C" required
                               class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                        <input type="text" name="questions[0][option_d]" placeholder="Optie D" required
                               class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                    </div>

                    <label class="block font-medium text-white">✅ Correcte optie</label>
                    <select name="questions[0][correct_option]" required
                            class="w-full bg-purple-900 text-white border border-purple-400 rounded px-3 py-2">
                        <option value="">-- Kies een optie --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>

                    <!-- Hoofdstuk -->
                    <div>
                        <label class="block font-medium text-white">📘 Hoofdstuk (optioneel)</label>
                        <input type="number" name="questions[0][chapter]"
                               class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2 placeholder:text-purple-300"
                               placeholder="Bijv. 1">
                    </div>
                </div>
            </div>

            <!-- Voeg vraag toe knop -->
            <button type="button" onclick="addQuestionBlock()"
                    class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 px-6 py-2 rounded-full shadow-md transition font-semibold">
                ➕ Nog een vraag toevoegen
            </button>

            <!-- Opslaan -->
            <div class="pt-6 text-center">
                <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-full font-bold shadow-lg transition transform hover:scale-105">
                    ✅ Quiz Aanmaken
                </button>
            </div>
        </form>

        <div class="text-center pt-4">
            <a href="{{ route('dashboard') }}" class="text-white underline hover:text-yellow-300 transition">⬅️ Terug naar Dashboard</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let questionIndex = 1;

    function addQuestionBlock() {
        const wrapper = document.getElementById('question-wrapper');
        const html = `
            <div class="bg-white/5 border border-purple-400 rounded-xl p-5 space-y-4 shadow-lg mt-6">
                <label class="block font-medium text-white">Vraag</label>
                <textarea name="questions[\${questionIndex}][question_text]" required
                          class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2 focus:outline-none"></textarea>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="questions[\${questionIndex}][option_a]" placeholder="Optie A" required
                           class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                    <input type="text" name="questions[\${questionIndex}][option_b]" placeholder="Optie B" required
                           class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                    <input type="text" name="questions[\${questionIndex}][option_c]" placeholder="Optie C" required
                           class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                    <input type="text" name="questions[\${questionIndex}][option_d]" placeholder="Optie D" required
                           class="bg-white/10 text-white border border-purple-400 rounded px-3 py-2">
                </div>

                <label class="block font-medium text-white">✅ Correcte optie</label>
                <select name="questions[\${questionIndex}][correct_option]" required
                        class="w-full bg-purple-900 text-white border border-purple-400 rounded px-3 py-2">
                    <option value="">-- Kies een optie --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>

                <!-- Hoofdstuk -->
                <div>
                    <label class="block font-medium text-white">📘 Hoofdstuk (optioneel)</label>
                    <input type="number" name="questions[\${questionIndex}][chapter]"
                           class="w-full bg-white/10 text-white border border-purple-400 rounded px-3 py-2 placeholder:text-purple-300"
                           placeholder="Bijv. 1">
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        questionIndex++;
    }
</script>
@endsection
