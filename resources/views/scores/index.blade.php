@extends('layouts.app')
@section('content')
<h1>Scores</h1>
<ul>
    @foreach($scores as $score)
    <li>{{ $score->user->name }} scored {{ $score->score }} on {{ $score->quiz->title }}</li>
    @endforeach
</ul>
@endsection