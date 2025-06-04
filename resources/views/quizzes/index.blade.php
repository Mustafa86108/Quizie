@extends('layouts.app')

@section('content')
<div class="pt-24 px-4 sm:px-6 min-h-screen bg-gradient-to-b from-[#150050] via-[#3F0071] to-[#FB2576]">

    <!-- Titel -->
    <h1 class="text-4xl font-extrabold text-center text-white mb-8 animate-bounce drop-shadow-xl">
         Kies een quiz om te starten
    </h1>

    <!-- Zoekveld + knop -->
    <div class="flex flex-col sm:flex-row items-center justify-between max-w-6xl mx-auto mb-12 gap-4">
        <input type="text" id="quizSearch"
               placeholder="🔍 Zoek quiz of boek..."
               class="w-full sm:w-2/3 px-5 py-3 text-sm text-white bg-white/10 backdrop-blur border border-white/30 rounded-full shadow-inner focus:outline-none focus:ring-2 focus:ring-yellow-400 placeholder:text-white placeholder:opacity-70 transition duration-300" />

        @if (auth()->user()?->role === 'teacher')
            <a href="{{ route('quizzes.create') }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-indigo-800 font-bold px-6 py-2 rounded-full shadow-lg transition transform hover:scale-105">
                ➕ Nieuwe Quiz
            </a>
        @endif
    </div>

    <!-- Quiz Cards -->
    <div id="quizGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-7xl mx-auto">
        @forelse ($quizzes as $quiz)
            @php
                $borderColor = match($quiz->id % 6) {
                    0 => 'border-pink-400',
                    1 => 'border-yellow-400',
                    2 => 'border-green-400',
                    3 => 'border-blue-400',
                    4 => 'border-purple-400',
                    default => 'border-orange-400'
                };
            @endphp

            <div class="quiz-card bg-white rounded-3xl shadow-xl overflow-hidden border-4 {{ $borderColor }} hover:shadow-2xl transition-all duration-300"
                 data-title="{{ strtolower($quiz->title) }}"
                 data-book="{{ strtolower($quiz->book->title ?? '') }}">

                <!-- Cover -->
                <div class="h-40 w-full overflow-hidden">
                    @if ($quiz->cover_image)
                        <img src="{{ asset('storage/' . $quiz->cover_image) }}"
                             alt="Quiz cover"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl bg-indigo-100 text-indigo-400">
                            📘
                        </div>
                    @endif
                </div>

                <!-- Inhoud -->
                <div class="p-5 text-center">
                    <h3 class="text-xl font-bold text-indigo-700 mb-1">{{ $quiz->title }}</h3>
                    <p class="text-sm text-gray-600">📖 {{ $quiz->book->title ?? 'Geen boek' }}</p>
                    <p class="text-sm text-pink-500">🧠 Vragen: {{ $quiz->questions->count() }}</p>

                    <!-- Start Button -->
                    <div class="mt-4 flex justify-center">
                        <a href="{{ route('quizzes.start', $quiz->id) }}"
                           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full text-lg shadow-md flex items-center gap-2 transition hover:scale-110">
                            ▶️ PLAY
                        </a>
                    </div>

                    <!-- Docent Opties -->
                    @if (auth()->user()?->role === 'teacher')
                    <div class="flex justify-center mt-4 flex-wrap gap-2">
                        <a href="{{ route('questions.create', $quiz->id) }}" class="icon-btn bg-yellow-400 hover:bg-yellow-500" title="Vraag toevoegen">➕</a>
                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="icon-btn bg-blue-500 hover:bg-blue-600" title="Quiz bewerken">✏️</a>
                        <a href="{{ route('questions.index', $quiz->id) }}" class="icon-btn bg-purple-400 hover:bg-purple-500" title="Bekijk vragen">📄</a>
                        <a href="{{ route('quizzes.feedback.overview', $quiz->id) }}" class="icon-btn bg-teal-500 hover:bg-teal-600" title="Bekijk feedback">💬</a>
                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="icon-btn bg-red-400 hover:bg-red-500 delete-button" data-title="{{ $quiz->title }}" title="Verwijder quiz">
                                🗑️
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-white text-lg italic">
                📭 Geen quizzen gevonden.
            </div>
        @endforelse
    </div>
</div>

<!-- Extra styles -->
<style>
    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        transition: transform 0.2s ease-in-out;
    }

    .icon-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('scripts')
<script>
    document.getElementById('quizSearch').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.quiz-card');

        cards.forEach(card => {
            const title = card.dataset.title;
            const book = card.dataset.book;

            card.style.display = (title.includes(query) || book.includes(query)) ? 'block' : 'none';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const form = button.closest('form');
                const title = button.dataset.title || "deze quiz";

                Swal.fire({
                    title: `🗑️ Quiz verwijderen?`,
                    html: `<strong class="text-pink-500">${title}</strong> wordt permanent verwijderd.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ja, verwijderen!',
                    cancelButtonText: 'Annuleren',
                    background: '#1e1b4b',
                    color: '#fff',
                    customClass: {
                        popup: 'rounded-xl shadow-xl',
                        confirmButton: 'bg-red-600 text-white px-6 py-2 rounded-full font-semibold shadow',
                        cancelButton: 'bg-gray-300 text-gray-800 px-6 py-2 rounded-full font-semibold shadow'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
