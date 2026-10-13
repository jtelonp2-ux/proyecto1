@extends('layout')

@section('contenido')
    <h1>Edit Task</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/tasks/{{ $tarea['id'] }}/edit" method="post">
        {!! csrf_field() !!}

        <label for="description">Description</label><br>
        <input type="text" id="description" name="description" value="{{ old('description', $tarea['description']) }}"><br><br>

        <button type="submit">Save</button>
        <a href="/tasks/{{ $tarea['id'] }}">Cancel</a>
    </form>
@endsection