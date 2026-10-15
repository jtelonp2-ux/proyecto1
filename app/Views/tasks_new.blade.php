@extends('layout')

@section('contenido')
    <h1>{{ lang('App.newTask') }}</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/tasks" method="post">
        {!! csrf_field() !!}

        <label for="description">{{ lang('App.description') }}</label><br>
        <input type="text" id="description" name="description" value="{{ old('description') }}"><br><br>

        <button type="submit">{{ lang('App.send') }}</button>
        <a href="/tasks">{{ lang('App.cancel') }}</a>
    </form>
@endsection