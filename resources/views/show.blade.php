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
    <div class="mb-4">
        <a href="{{ route('tasks.index') }}" class="link">
            <- All Tasks List
        </a>
    </div>

    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->description)
        <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
    @endif

    <p class="mb-4 text-sm text-slate-500"><i>created: {{ $task->created_at->diffForHumans() }} | last modified: {{ $task->updated_at->diffForHumans() }}</i></p>

    <p class="mb-4">
        @if($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
            <span class="font-medium text-red-500">Not Completed</span>
        @endif
    </p>

    <div class="flex gap-2"> 
        <a href="{{ route('tasks.edit', ['task'=> $task->id]) }}" class="btn">
            Edit Job
        </a>
    
        <form method="POST" action="{{ route('tasks.toggle-complete', ['task' => $task->id]) }}">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                Mark as: {{ $task->completed? 'not completed' : 'completed' }}
            </button>
        </form>
    
        <form action="{{ route('tasks.destroy', ['task' => $task->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete Task</button>
        </form>
    </div>
    
@endsection