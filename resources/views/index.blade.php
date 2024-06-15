@extends('layouts.app') 

@section('title', 'The List of Tasks')

@section('content')
    @forelse ($tasks as $task)
        <!-- route() is used to navigate to a different route from the blade template -->
        <a href={{ route('tasks.show', ['task' => $task->id]) }}>{{ $task->title }}</a>
        <br>
    @empty
        <p>No Tasks Available - Add Some!</p>
    @endforelse
@endsection


