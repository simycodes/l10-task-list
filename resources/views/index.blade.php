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
    
    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}" class="font-medium text-grey-700 underline decoration-pink-500">
            Add Task!
        </a>
    </nav>

    @forelse ($tasks as $task)
        <!-- route() is used to navigate to a different route from the blade template -->
        <a href={{ route('tasks.show', ['task' => $task->id]) }} @class(['line-through' => $task->completed])>
            {{ $task->title }}
        </a>
        <!-- <a href={{ route('tasks.show', ['task' => $task]) }}>{{ $task->title }}</a> -- ['task' => $task]) works also -->
        <br>
    @empty
        <p>No Tasks Available - Add Some!</p>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">{{ $tasks-> links() }}</nav>
    @endif
    <!-- links() function is used to display the available pages in line with amount of data
    retrieved from the database -->

@endsection


