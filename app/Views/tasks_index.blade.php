@extends('layout')

@section('contenido')
    <h1>{{ lang('App.tasks') }}</h1>

    <a href="/tasks/new">{{ lang('App.newTask') }}</a>

    <form action="/tasks" method="get">
        <label for="search">{{ lang('App.search') }}</label>
        <input type="text" id="search" name="search" value="{{ $busqueda }}">
        <button type="submit">{{ lang('App.search') }}</button>
    </form>

    @if (count($tareas) === 0)
        <p>{{ lang('App.noTasks') }}</p>
    @endif

    <ul>
        @foreach ($tareas as $tarea)
            <li><a href="/tasks/{{ $tarea['id'] }}">{{ $tarea['description'] }}</a></li>
        @endforeach
    </ul>

    {!! $pager->links('default', 'newer_older') !!}
@endsection