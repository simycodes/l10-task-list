@extends('layouts.app') 

@section('title', $task->title)

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
    <p>{{ $task->description }}</p>

    @if ($task->description)
        <p>{{ $task->long_description }}</p>
    @endif

    <p>{{ $task->created_at }}</p>
    <p>{{ $task->updated_at }}</p>

    <div>
        <form action="{{ route('tasks.destroy', ['task' => $task->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete Task</button>
        </form>
    </div>
    
@endsection