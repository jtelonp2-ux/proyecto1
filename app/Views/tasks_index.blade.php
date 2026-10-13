@extends('layout')

@section('contenido')
    <h1>Tasks</h1>

    <a href="/tasks/new">New Task</a>

    <form action="/tasks" method="get">
        <label for="search">Search</label>
        <input type="text" id="search" name="search" value="{{ $busqueda }}">
        <button type="submit">Search</button>
    </form>

    @if (count($tareas) === 0)
        <p>No tasks found.</p>
    @endif

    <ul>
        @foreach ($tareas as $tarea)
            <li><a href="/tasks/{{ $tarea['id'] }}">{{ $tarea['description'] }}</a></li>
        @endforeach
    </ul>

    {!! $pager->links() !!}
@endsection