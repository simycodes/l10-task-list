@extends('layouts.app') 

@section('title', 'The List of Tasks')

@section('styles')
    <style>
        .success-message {
            color: green;
            font-size: 1.2rem;
        }

        .error-message {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection('styles')

@section('content')
    @forelse ($tasks as $task)
        <!-- route() is used to navigate to a different route from the blade template -->
        <a href={{ route('tasks.show', ['task' => $task->id]) }}>{{ $task->title }}</a>
        <br>
    @empty
        <p>No Tasks Available - Add Some!</p>
    @endforelse
@endsection


