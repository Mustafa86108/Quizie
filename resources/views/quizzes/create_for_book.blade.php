@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ Nieuwe Quiz voor: <strong>{{ $book->title }}</strong></h2>

    <form action="{{ route('quiz.store.for.book', $book->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-bold mb-1">Quiz Titel:</label>
            <input type="text" name="title" id="title" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Quiz Aanmaken
        </button>
    </form>
</div>
@endsection
