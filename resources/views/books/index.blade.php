@extends('layouts.app')

@section('content')
<div class="pt-24 px-6 min-h-screen bg-gradient-to-br from-[#2a003f] via-[#4b0b8a] to-[#c9184a]">

    <!-- Titel + zoekveld + knop -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10 max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-white flex items-center gap-2">
            <span>📚</span> Alle Boeken
        </h1>

        <div class="flex gap-4 w-full md:w-auto">
            <input type="text" id="search" placeholder="🔍 Zoek op titel of beschrijving..."
                class="w-full md:w-72 px-5 py-2 text-sm rounded-full bg-purple-900 border border-purple-400 placeholder:text-purple-200 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-inner transition" />

            @if(auth()->user()?->role === 'teacher')
            <a href="{{ route('books.create') }}"
                class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-5 py-2 rounded-full shadow transition">
                ➕ Nieuw Boek
            </a>
            @endif
        </div>
    </div>

    <!-- Grid van boeken -->
    <div id="book-grid" class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
        @forelse($books as $book)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-[1.02] transition duration-300 book-card"
            data-title="{{ strtolower($book->title) }}"
            data-description="{{ strtolower($book->description) }}">

            <!-- Cover -->
            @if ($book->cover_image)
            <div class="relative h-56 w-full overflow-hidden">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Boek cover"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                @if($book->quizzes_count > 0)
                <span class="absolute top-2 left-2 bg-purple-700 text-white text-xs px-2 py-1 rounded-full shadow">
                    📊 {{ $book->quizzes_count }} quiz{{ $book->quizzes_count > 1 ? 'zen' : '' }}
                </span>
                @endif
            </div>
            @else
            <div class="h-56 bg-purple-100 flex items-center justify-center text-4xl text-purple-500">
                📘
            </div>
            @endif

            <!-- Inhoud -->
            <div class="p-4 text-center">
                <h2 class="font-bold text-purple-700 text-base truncate">{{ $book->title }}</h2>
                <p class="text-sm text-gray-600 mt-1 truncate">{{ $book->description }}</p>
            </div>

            <!-- Acties -->
            <div class="flex justify-around items-center py-3 bg-gray-100 border-t text-xl text-gray-600 space-x-2">
                <a href="{{ route('books.show', $book->id) }}" class="hover:text-purple-600 transition"
                    title="📄 Bekijk PDF">📄</a>

                @if(auth()->user()?->role === 'teacher')
                <a href="{{ route('books.edit', $book->id) }}" class="hover:text-yellow-500 transition"
                    title="✏️ Bewerken">✏️</a>

                <a href="{{ route('quizzes.create', ['book_id' => $book->id]) }}"
                    class="hover:text-green-600 transition" title="➕ Voeg Quiz toe">➕</a>

                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="delete-button hover:text-red-500 transition text-xl flex items-center justify-center"
                        title="🗑️ Verwijder"
                        data-title="{{ $book->title }}">
                        🗑️
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <p class="text-white italic text-center col-span-full">📭 Geen boeken gevonden.</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //  Zoekfilter
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.book-card');

        cards.forEach(card => {
            const title = card.dataset.title;
            const desc = card.dataset.description;
            card.style.display = (title.includes(query) || desc.includes(query)) ? 'block' : 'none';
        });
    });

    //  Mooie delete popup
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const title = this.dataset.title || 'dit boek';

            Swal.fire({
                title: 'Boek verwijderen?',
                html: `Weet je zeker dat je <strong class="text-yellow-300">${title}</strong> wilt verwijderen?`,
                icon: 'warning',
                background: '#2a003f',
                color: '#fff',
                showCancelButton: true,
                confirmButtonText: 'Ja, verwijder',
                cancelButtonText: 'Annuleer',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-xl shadow-xl',
                    confirmButton: 'bg-red-500 text-white px-6 py-2 rounded-full font-semibold shadow',
                    cancelButton: 'bg-white text-gray-800 px-6 py-2 rounded-full font-semibold shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
