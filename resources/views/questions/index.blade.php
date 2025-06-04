@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeInUp 0.7s ease-out forwards;
    }

    .question-card:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="min-h-screen pt-24 pb-16 px-6 bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a] text-white fade-in">
    <div class="max-w-6xl mx-auto space-y-8">

        <!-- Titel -->
        <h1 class="text-3xl font-extrabold text-yellow-300 text-center">
            📋 Vragenlijst voor: <span class="text-white">{{ $quiz->title }}</span>
        </h1>

        <!-- Succesmelding -->
        @if (session('success'))
            <div class="bg-green-200 text-green-900 p-4 rounded-xl shadow border border-green-400 text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Actieknop -->
        <div class="text-center">
            <a href="{{ route('questions.create', $quiz->id) }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-semibold px-6 py-3 rounded-full shadow-md transition transform hover:scale-105 inline-block">
                ➕ Nieuwe Vraag Toevoegen
            </a>
        </div>

        <!-- Vragenlijst -->
        @if ($quiz->questions->count())
            <ul class="space-y-4">
                @foreach ($quiz->questions as $index => $question)
                <li class="bg-white/10 border border-purple-300 text-white rounded-2xl p-5 shadow-lg question-card transition transform duration-300">
                    <div class="flex justify-between items-start gap-6 flex-wrap">
                        
                        <!-- Vraag en Hoofdstuk -->
                        <div class="flex-1 space-y-2">
                            
                            <!-- Hoofdstuk -->
                            @if($question->chapter)
                                <p class="text-sm text-purple-200">📘 Hoofdstuk {{ $question->chapter }}</p>
                            @endif
                
                            <!-- Vraag -->
                            <p class="text-lg font-semibold">
                                <span class="text-yellow-300">{{ $index + 1 }}.</span> {{ $question->question_text }}
                            </p>
                        </div>
                
                        <!-- Acties -->
                        <div class="flex items-center gap-4 text-sm whitespace-nowrap">
                            <a href="{{ route('questions.edit', $question->id) }}"
                               class="text-blue-300 hover:text-blue-100 transition font-medium flex items-center gap-1">
                                ✏️ Bewerken
                            </a>
                
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-button icon-btn bg-red-500 hover:bg-red-600">
                                    🗑️
                                </button>
                            </form>
                        </div>
                
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-purple-200 text-center mt-10 italic">
                📭 Er zijn nog geen vragen toegevoegd aan deze quiz.
            </p>
        @endif

        <!-- Terug -->
        <div class="text-center pt-8">
            <a href="{{ route('quizzes.index') }}"
               class="text-white underline hover:text-yellow-300 transition text-sm inline-flex items-center gap-1">
                ⬅️ Terug naar quiz overzicht
            </a>
        </div>

    </div>
</div>
<!-- SweetAlert CDN & Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const form = button.closest('form');

                Swal.fire({
                    title: 'Weet je het zeker?',
                    text: "Deze vraag wordt permanent verwijderd.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ja, verwijderen!',
                    cancelButtonText: 'Annuleren',
                    customClass: {
                        popup: 'rounded-xl shadow-lg',
                        confirmButton: 'bg-red-600 text-white px-5 py-2 rounded-full font-bold',
                        cancelButton: 'bg-gray-200 text-gray-700 px-5 py-2 rounded-full'
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
