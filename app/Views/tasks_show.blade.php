@extends('layout')

@section('contenido')
    <h1>Task</h1>

    <a href="/tasks">&lt;&lt; back to index</a>

    <p><strong>ID</strong><br>{{ $tarea['id'] }}</p>
    <p><strong>Description</strong><br>{{ $tarea['description'] }}</p>
    <p><strong>Created at</strong><br>{{ $tarea['created_at'] }}</p>
    <p><strong>Updated at</strong><br>{{ $tarea['updated_at'] }}</p>

    <a href="/tasks/{{ $tarea['id'] }}/edit">Edit</a>

    <form action="/tasks/{{ $tarea['id'] }}/delete" method="post"
          onsubmit="return confirm('Are you sure?');">
        {!! csrf_field() !!}
        <button type="submit">Delete</button>
    </form>
@endsection